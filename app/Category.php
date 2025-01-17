<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subcategory()
    {
        return $this->hasMany('App\Subcategory');
    }
    public function product()
    {
        return $this->hasMany('App\Product');
    }
}
