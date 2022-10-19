<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subscriptions\StoreSubscriptionRequest;
use App\Models\Client;
use App\Models\InvoiceSubscription;
use App\Models\Plan;
use App\Models\Subscription;
use App\Traits\FileUpload;

class SubscriptionController extends Controller
{
    use FileUpload;

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

        return view('admin.subscriptions.index')->with('subscriptions', $subscriptions);
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

        $subscription = Subscription::create($data);

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
