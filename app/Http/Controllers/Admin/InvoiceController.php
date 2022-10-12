<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Invoices\StoreInvoiceRequest;
use App\Models\Attachment;
use App\Models\Invoice;
use App\Models\InvoiceSubscription;
use App\Models\Subscription;
use App\Traits\FileUpload;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    use FileUpload;
    public function store(StoreInvoiceRequest $request)
    {

        $data = $request->validated();
        $duration = $data['duration'];
        $data['created_by'] = request()->user()->id;

        try {
            DB::beginTransaction();
            if (isset($data['invoice_image']) && $data['invoice_image']) {
                $attachment = $this->uploadFile($data['invoice_image']);
                $attachment = Attachment::create($attachment);
                $data['invoice_image'] = $attachment->id;
            }
            $invoice = Invoice::create($data);

            $subscriptionIds = array_filter(explode(',', $request->input('subscriptions')));
            $subscriptions = Subscription::whereIn('id', $subscriptionIds)->get();

            if ($subscriptions && count($subscriptions)) {
                foreach ($subscriptions as $subscription) {
                    $expiration = Carbon::parse($subscription->start_from)->{"add" . ucwords($subscription->plan->duration) . 's'}($duration);
                    $rows[$subscription->id] = InvoiceSubscription::create([
                        'invoice_id' => $invoice->id,
                        'subscription_id' => $subscription->id,
                        'duration' => $duration,
                        'expiration_date' => $expiration,
                    ]);
                    $subscription->update([
                        'expiration_date' => $expiration,
                        'status' => Subscription::STATUSES[1]['id']
                    ]);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->sendError();
        }

        return $this->sendResponse([
            'invoice' => $invoice,
            'rows' => $rows
        ] , ucwords(t('invoice added successfully.')));
    }
}
