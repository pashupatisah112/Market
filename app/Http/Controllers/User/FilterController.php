<?php

namespace App\Http\Controllers\User;

use App\Color;
use App\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Product;
use App\Sale;
use App\Rating;
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
            $ids=[];
            $pops=Product::where('sub_category_id',$sub->id)->get();
            foreach($pops as $pop){
                array_push($ids,$pop->id);
            }
            $sale=Sale::whereIn('product_id',$ids)->select('product_id','quantity',DB::raw('sum(*) as total'))->groupBy('quantity')->orderBy('quantity','desc');
            return response()->json($sale);
        }
        else if($field=='Average Rating')
        {
            $ids=[];
            $pops=Product::where('sub_category_id',$sub->id)->get();
            foreach($pops as $pop){
                array_push($ids,$pop->id);
            }
            $rated=DB::table('ratings')->whereIn('product_id',$ids)->select(['product_id',DB::raw('avg(rating) as avrg')])->groupBy('product_id')->get();
            $selected_ids=[];
            foreach($rated as $rate){
                array_push($selected_ids,$rate->product_id);
            } 
            rsort($selected_ids);
            $prod=Product::whereIn('id',$selected_ids)->select(['id','title','price','image','product_code'])->with('rating:product_id,rating')->get();
            return response()->json($prod);

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
