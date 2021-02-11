<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon;

class AnalyticsController extends Controller
{
    public function getDailyData()
    {
        $users=DB::table('users')->select("created_at",DB::raw('count(*) as total'))->groupBy("created_at")->get();
        $orders=DB::table('orders')->select("created_at",DB::raw('count(*) as total'))->groupBy("created_at")->get();
        $userData=[];
        $orderData=[];
        foreach($users as $user)
        {
            $d=array("date"=>Carbon\Carbon::parse($user->created_at)->day,"count"=>$user->total);
            array_push($userData,$d);
        }
        foreach($orders as $order)
        {
            $e=array("date"=>Carbon\Carbon::parse($order->created_at)->day,"count"=>$order->total);
            array_push($orderData,$e);
        }
        
        return response()->json(['user_data'=>$userData,'order_data'=>$orderData]);

    }
    public function getDisplayData()
    {
        $user_count=User::count();
        $delivery_count=Order::where('delivery_status','Delivered')->count();
        return response()->json(['user_count'=>$user_count,'delivery_count'=>$delivery_count]);
    }
}
