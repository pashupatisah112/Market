<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class CustomerController extends Controller
{
    public function getCustomers(Request $request){
        $items=$request->per_page;
        $customers=User::where('role_id',2)->paginate($items);
        return response()->json($customers);
    }
}
