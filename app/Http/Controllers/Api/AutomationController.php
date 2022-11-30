<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Traits\RestTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\automation_notification;


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
                $client_data = [] ;
                foreach ($client_subscriptions as $client_subscription)
                {
                    $single_data = [];
                    $single_data['description'] = $client_subscription->description ;
                    $single_data['expiration_date'] = $client_subscription->expiration_date ;
                    $single_data['cost'] = $client_subscription->cost ;
                    $single_data['company_phone'] = $client_subscription->client->company_phone;
                    $single_data['company_name'] = $client_subscription->client->company_name;
                    $single_data['email'] = $client_subscription->client->email;
                    $single_data['subscription_id'] = $client_subscription->id;
                    array_push($client_data,$single_data);
                }
                //dd($client_data);
                array_push($data,$client_data);
            }
            return $this->sendResponse($data,"success",200);
            //  return $data ;

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
        $notification =  automation_notification::where('subscription_id',$subscription_id)->first();

        if(!empty($notification))
        {
           $update_at = Carbon::createFromFormat('Y-m-d H:i:s', $notification['updated_at']);
           //date('Y-m-d',strtotime($notification['updated_at']));
           $date_per_check = Carbon::now()->addDays(10);
            $result = $date_per_check->gt($update_at);
            if($result == true)
            {
                return $result."sss";
            }

        }else
        {
            return "ddddd";
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
