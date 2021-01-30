<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Color;
use App\Company;
use App\Http\Controllers\Controller;
use App\ProductType;
use App\Subcategory;
use App\Product;
use App\Size;
use App\Tag;
use App\Photo;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts(){
        $products=Product::with('category')->with('subCategory')->with('company')->with('productType')->with('color')->with('size')->with('tag')->with('photo')->get();
        return response()->json($products);
    }
    public function productSup()
    {
        $category=Category::all();
        $subCategory=Subcategory::all();
        $productType=ProductType::all();
        $company=Company::all();
        $size=Size::all();
        $color=Color::all();
        return response()->json(['category'=>$category,'subCategory'=>$subCategory,'productType'=>$productType,'company'=>$company,'size'=>$size,'color'=>$color]);
    }
    public function getProductTags(Request $request)
    {
        $tag=Tag::where('product_id',$request->product_id)->select('id','tag_name')->get();
        $tags=[];
        foreach($tag as $t){
            array_push($tags,$t->tag_name);
        }
        return response()->json($tags);
    }    
    public function store(Request $request)
    {
        $product=new Product;
        $product->title=$request->title;
        $product->price=$request->price;
        $request->product_code=$request->code;
        $product->product_type_id=$request->product_type_id;
        $product->category_id=$request->category_id;
        $product->sub_category_id=$request->subCategory_id;
        $product->company_id=$request->company_id;
        $product->description=$request->description;
        
        $product->save();
        
        $product->color()->sync($request->color_name);
        $product->size()->sync($request->size);
        $tags=$request->tag_name;
        foreach($tags as $tag){
            $ta=new Tag;
            $ta->tag_name=$tag;
            $ta->product_id=$product->id;
            $ta->save();
        }
        return response()->json($product);
        
    }
    public function update(Request $request, $id)
    {
        $product=Product::find($id);
        $product->title=$request->title;
        $product->price=$request->price;
        $request->product_code=$request->code;
        $product->product_type_id=$request->product_type_id;
        $product->category_id=$request->category_id;
        $product->sub_category_id=$request->subCategory_id;
        $product->company_id=$request->company_id;
        $product->description=$request->description;
        
        $product->save();
        
        $product->color()->sync($request->color_name);
        $product->size()->sync($request->size);
        //  $tags=$request->tag_name;
        // foreach($tags as $tag){
        //     $ta=new Tag;
        //     $ta->tag_name=$tag;
        //     $ta->product_id=$product->id;
        //     $ta->save();
        // }
        return response()->json($product);
        }
    public function delete($id)
    {
        $product=Product::find($id)->delete();
        $product->color()->detach();
        $product->size()->detach();
    }
    public function imageUpload(Request $request)
    {
        $file=$request->selectedFile->store('productImages');
        $photo=new Photo;
        $photo->product_id=$request->id;
        $photo->image=$file;
        $photo->save();
        $product=Product::where('id',$request->id)->with('photo')->get();
        return response()->json($product);
    }
    public function addPrimaryImage(Request $request)
    {
        $path = $request->selectedFile->store('productImages');
        $image=Product::find($request->id);
        $image->image=$path;
        $image->save();
        $product=Product::where('id',$request->id)->with('photo')->first();
        return response()->json($product);
    }
    public function updateImage(Request $request)
    {
        $product=Product::where('id',$request->id)->with('photo')->first();
        return response()->json($product);
    }
    
}
