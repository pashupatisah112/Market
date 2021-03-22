<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category');
    } 
    public function subCategory()
    {
        return $this->belongsTo('App\SubCategory');
    }
    public function color()
    {
        return $this->belongsToMany('App\Color','color_products');
    }
    public function size()
    {
        return $this->belongsToMany('App\Size','product_sizes');
    }
    public function tag()
    {
        return $this->hasMany('App\Tag');
    }
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
    public function productType()
    {
        return $this->belongsTo('App\ProductType');
    }
    public function cart()
    {
        return $this->hasMany('App\Cart');
    }
    public function photo()
    {
        return $this->hasMany('App\Photo');
    }
    public function rating()
    {
        return $this->hasMany('App\Rating');
    }
}
