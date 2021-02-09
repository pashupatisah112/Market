<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function company()
    {
        return $this->hasMany('App\Company');
    }
    public function product()
    {
        return $this->hasMany('App\Product');
    }
}
