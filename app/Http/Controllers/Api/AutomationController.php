<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Traits\RestTrait;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\automation_notification;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
class AutomationController extends Controller
{
    use RestTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $data = [];
        $currentDateTime = Carbon::now();
        $end_per_date = Carbon::now()->addMonths(1);
        $subscriptions = Subscription::whereDate('expiration_date', '<=', $end_per_date)
            ->whereDate('expiration_date', '>=', $currentDateTime)->get();
        // 1 month results
        if(!$subscriptions->isEmpty())
        {
            // 3 months results for client_id
            foreach ($subscriptions as $subscription)
            {
                $client_end_per_date = Carbon::now()->addMonths(3);
                $client_subscriptions = Subscription::whereDate('expiration_date', '<=', $client_end_per_date)
                    ->whereDate('expiration_date', '>=', $currentDateTime)->where('client_id',$subscription->client_id)->get();
                $client_data = [];

                foreach ($client_subscriptions as $client_subscription)
                {

                    $single_data = [];
                    $single_data['description'] = $client_subscription->description;
                    $single_data['expiration_date'] = $client_subscription->expiration_date;
                    $single_data['cost'] = $client_subscription->cost;
                    $single_data['company_phone'] = $client_subscription->client->company_phone;
                    $single_data['company_name'] = $client_subscription->client->company_name;
                    $single_data['email'] = $client_subscription->client->email;
                    $single_data['subscription_id'] = $client_subscription->id;
                    $single_data['client_id'] = $client_subscription->client_id;
                    $single_data['count'] = count($client_subscriptions);
                    $plan = Plan::where("id",$client_subscription->plan_id)->first();
                    $single_data['plan'] = $plan->name;
                    array_push($client_data,$single_data);
                }
                foreach ($client_data as $client_sub)
                {
                    if(!in_array($client_sub, $data))
                    {
                        array_push($data,$client_sub);
                    }
                }
            }
            return $this->sendResponse($data,"success",200);
        }else
        {
            return $this->sendResponse($data,"fail",200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notification = $request->all();
        $notification = automation_notification::create($notification);
        return $this->sendResponse($notification,"success",200);
    }


    public function checkifnotified($subscription_id)
    {
       $notification = automation_notification::where('subscription_id',$subscription_id)->orderby('updated_at','desc')->first();
       $today = Carbon::now();
       if (!empty($notification))
       {
           $next_notification = $notification['updated_at']->addDays(10);
           if ($today->gt($next_notification))
           {
               // you can notify client again
               return $this->sendResponse(json_decode("1"),"success",200);


           }else
           {

               return $this->sendResponse(json_decode("0"),"success",200);
           }
       }else
       {
           // you can sent the first notification for client
           return $this->sendResponse(json_decode("2"),"success",200);
       }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
