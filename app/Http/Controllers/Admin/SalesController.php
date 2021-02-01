<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $sale=Sale::with('user:id,name')->with('product')->get();
        return response()->json($sale);
    }
    public function deliveryStatus(Request $request)
    {

    }

}
