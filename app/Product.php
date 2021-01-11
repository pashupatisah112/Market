<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category');
    } 
    public function subcategory()
    {
        return $this->belongsTo('App\SubCategory');
    }
    public function color()
    {
        return $this->belongsToMany('App\Color','color_product');
    }
    public function size()
    {
        return $this->belongsToMany('App\Size','product_size');
    }
    public function tag()
    {
        return $this->belongsToMany('App\Tag','product_tag');
    }
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
    public function producttype()
    {
        return $this->belongsTo('App\ProductType');
    }
    public function photos()
    {
        return $this->hasMany('App\Photos');
    }
}
