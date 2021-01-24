<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function product()
    {
        return $this->hasMany('App\Product');
    }
    public function subCategory()
    {
        return $this->belongsTo('App\SubCategory');
    }
}
