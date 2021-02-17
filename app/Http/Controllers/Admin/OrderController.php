<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\Sale;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrders()
    {
        $order=Order::with('user:id,name')->with('paymentGateway:id,gateway_name')->get();
        return response()->json($order);
    }
    public function getOrderDetail(Request $request)
    {
        $sale=Sale::where('order_id',$request->order_id)->with('product')->with('color')->with('size')->get();
        $total=Sale::where('order_id',$request->order_id)->sum('total');
        return response()->json(['sale'=>$sale,'total'=>$total]);
    }
    public function changeDeliveryStatus(Request $request)
    {
        $order=Order::find($request->id);
        $order->delivery_status=$request->status;
        $order->save();
        $ord=Order::where('id',$order->id)->with('user:id,name')->with('paymentGateway:id,gateway_name')->first();
        return response()->json($ord);
    }
    public function deleteOrder(Request $request)
    {
        Order::find($request->id)->delete();
    }
}
