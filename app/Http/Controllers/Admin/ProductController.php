<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Color;
use App\ColorProduct;
use App\Company;
use App\Http\Controllers\Controller;
use App\ProductType;
use App\Subcategory;
use App\Product;
use App\Size;
use App\Tag;
use App\Photo;
use App\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function myProducts(Request $request){
        $items=$request->per_page;
        $products=Product::with('category')->with('subCategory')->with('company')->with('productType')->with('color')->with('size')->with('tag')->with('photo')->paginate($items);
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
        $this->validate($request,[
            'code'=> 'unique:products,product_code',
        ]);
        $product=new Product;
        $product->title=$request->title;
        $product->price=$request->price;
        $product->product_code=$request->code;
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
        $prod=Product::where('id',$product->id)->with('category')->with('subCategory')->with('company')->with('productType')->with('color')->with('size')->with('tag')->with('photo')->first();

        return response()->json($request);
        
    }
    public function update(Request $request, $id)
    {
         $product=Product::find($id);
        $product->title=$request->title;
        $product->price=$request->price;
        $product->product_code=$request->code;
        $product->product_type_id=$request->product_type_id;
        $product->category_id=$request->category_id;
        $product->sub_category_id=$request->subCategory_id;
        $product->company_id=$request->company_id;
        $product->description=$request->description;
        
        $product->save();

        DB::table('product_sizes')->where('product_id',$id)->delete();
        DB::table('color_products')->where('product_id',$id)->delete();
        DB::table('tags')->where('product_id',$id)->delete();
        
        $sizes=$request->size;

        for($x=0;$x < count($sizes);$x++){
            $size=new ProductSize;
            $size->product_id=$product->id;
            $size->size_id=$sizes[$x];
            $size->save();
        }
        $colors=$request->color_name;
        for($x=0; $x < count($colors);$x++){
            $color=new ColorProduct;
            $color->product_id=$product->id;
            $color->color_id=$colors[$x];
            $color->save();
        }

        $tags=$request->tag_name;
        for($x=0; $x < count($tags);$x++){
            $tag=new Tag;
            $tag->product_id=$product->id;
            $tag->tag_name=$tags[$x];
            $tag->save();
        }

        $prod=Product::where('id',$id)->with('category')->with('subCategory')->with('company')->with('productType')->with('color')->with('size')->with('tag')->with('photo')->first();

        return response()->json($prod);
        }
    public function delete($id)
    {
        $product=Product::find($id)->delete();
        $product->color()->detach();
        $product->size()->detach();
    }
    public function imageUpload(Request $request)
    {
        //$file=$request->selectedFile->store('productImages'); works fine on simple upload
        $photo=new Photo;
        $photo->product_id=$request->product_id;
        $photo->image=$request->image;
        $photo->save();
        $product=Product::where('id',$request->product_id)->with('category')->with('subCategory')->with('company')->with('productType')->with('color')->with('size')->with('tag')->with('photo')->first();
        return response()->json($product);
    }
    public function addPrimaryImage(Request $request)
    {
        // $path = $request->selectedFile->store('productImages'); //works with simple database upload 
        $image=Product::find($request->product_id);
        $image->image=$request->file;
        $image->save();
        $product=Product::where('id',$request->product_id)->with('category')->with('subCategory')->with('company')->with('productType')->with('color')->with('size')->with('tag')->with('photo')->first();
        return response()->json($product);
    }
    public function getSecondaryImages(Request $request)
    {
        $image=Photo::where('product_id',$request->id)->get();
        return response()->json($image);
    }
    public function changeProductStatus(Request $request)
    {
        $prod=Product::find($request->product_id);
        $prod->status=$request->status;
        $prod->save();
        $products=Product::where('id',$prod->id)->with('category')->with('subCategory')->with('company')->with('productType')->with('color')->with('size')->with('tag')->with('photo')->first();

        return response()->json($products);
    }
    public function deleteSecImage(Request $request)
    {
        Photo::find($request->secId)->delete();
        return 'Image Deleted';
    }
}
