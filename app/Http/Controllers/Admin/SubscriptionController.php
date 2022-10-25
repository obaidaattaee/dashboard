<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subscriptions\StoreSubscriptionRequest;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceSubscription;
use App\Models\Plan;
use App\Models\Subscription;
use App\Traits\FileUpload;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    use FileUpload;

    /**
     * show table of subscriptions if that request from browser,
     * send table only id requested from ajax request
     */
    public function index()
    {

        $limit = request()->input('limit', 10);
        $subscriptions = Subscription::tableFilter()
            ->orderBy(
                InvoiceSubscription::select('expiration_date')
                    ->whereColumn('invoice_subscription.subscription_id', 'subscriptions.id')
                    ->latest()
                    ->take(1)
            )
            ->paginate($limit, ['*'], 'subscriptions');
        if (request()->ajax()) {
            return $this->sendResponse([
                'data' => view('admin.subscriptions.table')->with('subscriptions', $subscriptions)->render(),
                'container_class' => 'subscriptions-content',
            ]);
        }

        $clients = Client::get();
        $plans = Plan::get();


        return view('admin.subscriptions.index')
            ->with('subscriptions', $subscriptions)
            ->with('clients', $clients)
            ->with('plans', $plans);
    }

    public function create()
    {
        $subscription = null;
        $clients = Client::get();
        $plans = Plan::get();
        return view('admin.subscriptions.edit')
            ->with('clients', $clients)
            ->with('plans', $plans)
            ->with('subscription', $subscription);
    }

    public function store(StoreSubscriptionRequest $request)
    {
        $data = $request->validated();
        $data['creatad_by'] = request()->user()->id;

        try {
            DB::beginTransaction();

            $subscription = Subscription::create($data);

            $invoice = Invoice::create([
                'invoice_number' => "XXXXXXXXX",
                'description' => $data['description'],
                'duration' => object_get($subscription, 'plan.duration'),
                'invoice_cost' => object_get($subscription, 'quantity', 1) * object_get($subscription, 'cost', object_get($subscription, 'plan.cost')),
            ]);

            $invoiceSubscription = InvoiceSubscription::create([
                'invoice_id' => $invoice->id,
                'subscription_id' => $subscription->id,
                'duration' => object_get($subscription, 'plan.duration'),
                'expiration_date' => $data['expiration_date'],
                'cost' => $subscription->cost,
                'start_from' => $data['start_from']
            ]);

            $subscription->update([
                'status' => Subscription::STATUSES[1]['id']
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->sendError();
        }
        return $this->sendResponse($subscription, t('subscription added successfully'));
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return $this->sendResponse([], t('subscription deleted successfully.'));
    }


    public function edit(Subscription $subscription)
    {
        $clients = Client::get();
        $plans = Plan::get();
        return view('admin.subscriptions.edit')
            ->with('subscription', $subscription)
            ->with('clients', $clients)
            ->with('plans', $plans);
    }

    public function update(StoreSubscriptionRequest $request, Subscription $subscription)
    {
        $data = $request->validated();

        $subscription->update($data);

        return $this->sendResponse($subscription, t('subscription updated successfully'));
    }

    public function show(Subscription $subscription)
    {
        $limit = request()->input('limit', 10);
        $subscriptions = Subscription::where('subscription_id', $subscription)->tableFilter()->paginate($limit, ['*'], 'subscriptions');
        return view('admin.subscriptions.show')
            ->with('subscriptions', $subscriptions)
            ->with('subscription', $subscription);
    }
}
