<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class CustomerController extends Controller
{
    public function getCustomers(){
        $customers=User::where('role_id',2)->get();
        return response()->json($customers);
    }
}
