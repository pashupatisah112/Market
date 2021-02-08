<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function verifyKhaltiPayment(Request $request)
    {
        $args = http_build_query(array(
            'token' => $request->token,
            'amount'  => $request->amount
        ));
        
        $url = "https://khalti.com/api/v2/payment/verify/";
        
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $headers = ['Authorization: Key test_secret_key_1ddbd3519c234cfda272b740b8cc69d8'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return response()->json(['a'=>$response,'b'=>$status_code]);
        //return $request->data->token;
        
    }
}
