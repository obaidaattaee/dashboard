<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceSubscription;
use App\Models\Plan;
use App\Models\Subscription;

class DashboardController extends Controller
{
    public function index()
    {
        $limit = request()->input('limit', 10);
        $subscriptions = Subscription::tableFilter()
            ->orderBy(
                InvoiceSubscription::select('expiration_date')
                    ->whereColumn('invoice_subscription.subscription_id', 'subscriptions.id')
                    ->latest()
                    ->take(1),
                'desc'
            )->paginate($limit, ['*'], 'subscriptions');
        if (request()->ajax()) {
            return $this->sendResponse([
                'data' => view('admin.subscriptions.table')->with('subscriptions', $subscriptions)->render(),
                'container_class' => 'subscriptions-content',
            ]);
        }

        $data['clients'] = Client::count();
        $data['plans'] = Plan::count();
        $data['subscriptions'] = Subscription::count();
        $data['invoices'] = Invoice::count();

        return view('dashboard')->with('subscriptions', $subscriptions)->with('data', $data);
    }
}
