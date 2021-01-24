<?php

namespace App\Http\Controllers\User;

use App\Color;
use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function getFilters(Request $request)
    {
        $color=Color::all();
        $subcat=SubCategory::where('subCategory_name',$request->subCat)->with('company')->get();
        return response()->json(['color'=>$color,'subCategory'=>$subcat]);
    }
}
