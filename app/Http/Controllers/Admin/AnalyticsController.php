<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon;

class AnalyticsController extends Controller
{
    public function getDailyData()
    {
        $users=DB::table('users')->select("created_at",DB::raw('count(*) as total'))->groupBy("created_at")->get();
        $orders=DB::table('sales')->select("created_at",DB::raw('count(*) as total'))->groupBy("created_at")->get();
        $userData=[];
        foreach($users as $user)
        {
            $d=array("date"=>Carbon\Carbon::parse($user->created_at)->day,"count"=>$user->total);
            array_push($userData,$d);
        }
        
        return response()->json($userData);

    }
}
