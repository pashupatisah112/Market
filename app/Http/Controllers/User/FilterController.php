<?php

namespace App\Http\Controllers\User;

use App\Color;
use App\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Product;
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
    public function sortBy(Request $request)
    {
        $field=$request->field;
        $sub=SubCategory::where('subCategory_name',$request->subCat)->first();
        $product=null;
        if($field=='Default')
        {
            $product=Product::where('sub_category_id',$sub->id)->select(['id','title','price','image','product_code'])->get();
        }
        else if($field=='Popularity')
        {
            //depend on sale
        }
        else if($field=='Average Rating')
        {
            $product=DB::table('products')
                    ->join('ratings','products.id','=','ratings.product_id')
                    ->select(['products.id','products.title','products.price','products.image','products.product_code','products.title',DB::raw('avg(ratings.rating) as ravg')])
                    ->where('sub_category_id',$sub->id)
                    ->groupBy('products.id')
                    ->orderBy('ravg','desc')
                    ->get();
             return response()->json($product);

        }
        else if($field=='Newest')
        {
            $product=Product::where('sub_category_id',$sub->id)->select(['id','title','price','image','product_code'])->latest()->get();
        }
        else if($field=='Price:Low to High')
        {
            $product=Product::where('sub_category_id',$sub->id)->select(['id','title','price','image','product_code'])->sortBy('price')->get();
        }
        else if($field=='Price: High to Low')
        {
            $product=Product::where('sub_category_id',$sub->id)->select(['id','title','price','image','product_code'])->sortBy('price','desc')->get();
        }
        return response()->json($product);

    }
    public function colorFilter(Request $request)
    {
        
    }
        
    public function priceFilter(Request $request)
    {
        $sub=SubCategory::where('subCategory_name',$request->subCat)->first();
        $product=Product::where('sub_category_id',$sub->id)->whereBetween('price',[$request->low_range,$request->high_range])->get();
        return response()->json($product);
    }
    public function companyFilter(Request $request)
    {
        $sub=SubCategory::where('subCategory_name',$request->subCat)->first();
        $comp=Company::where('company_name',$request->name)->first();
        $product=Product::where('sub_category_id',$sub->id)->where('company_id',$comp->id)->get();
        return response()->json($product);
    }
}
