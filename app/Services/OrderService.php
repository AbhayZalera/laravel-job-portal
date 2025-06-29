<?php

namespace App\Services;

use App\Models\Order;
use App\Models\UserPlan;
use Auth;
use Session;

class OrderService
{
    static function storeOrder(
        string $transactionId,
        string $paymentProvider,
        string $amount,
        string $paidInCurrency,
        string $paymentStatus
    ) {
        $order = new Order();
        $order->company_id = Auth::user()->company->id;
        $order->plan_id = Session::get('selected_plan')['id'];
        $order->package_name = Session::get('selected_plan')['label'];
        $order->transaction_id = $transactionId;
        $order->order_id = uniqid();
        $order->payment_provider = $paymentProvider;
        $order->amount = $amount;
        $order->paid_in_currency = $paidInCurrency;
        $order->default_amount =  Session::get('selected_plan')['price'] . config('settings.site_default_currency');
        $order->payment_status = $paymentStatus;
        $order->save(); // save the order
    }

    static function setUserPlan()
    {
        $userPlan = UserPlan::where('company_id', Auth::user()->company->id)->first();
        // dd($userPlan);
        UserPlan::updateOrCreate(
            ['company_id' => Auth::user()->company->id],
            [
                'plan_id' => Session::get('selected_plan')['id'],
                'job_limit' => $userPlan?->job_limit ? $userPlan?->job_limit + Session::get('selected_plan')['job_limit']
                    : Session::get('selected_plan')['job_limit'],
                'featured_job_limit' => $userPlan?->featured_job_limit ? $userPlan?->featured_job_limit +
                    Session::get('selected_plan')['featured_job_limit'] : Session::get('selected_plan')['featured_job_limit'],
                'highlight_job_limit' => $userPlan?->highlight_job_limit ? $userPlan?->highlight_job_limit +
                    Session::get('selected_plan')['highlight_job_limit'] :  Session::get('selected_plan')['highlight_job_limit'],
                'profile_verified' => Session::get('selected_plan')['profile_verified']
            ]
        );
    }
}
