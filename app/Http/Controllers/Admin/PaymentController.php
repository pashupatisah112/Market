<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PaymentGateway;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(){
        $payment=PaymentGateway::all();
        return response()->json($payment);
    }
    public function store(Request $request)
    {
        $payment=new PaymentGateway;
        $payment->gateway_name=$request->gateway_name;
        $payment->save();
        return response()->json($payment);
    }
    public function update(Request $request,$id)
    {
        $payment=PaymentGateway::find($id);
        $payment->gateway_name=$request->gateway_name;
        $payment->save();
        return response()->json($payment);
    }
    public function delete($id)
    {
         PaymentGateway::find($id)->delete();
    }
}
