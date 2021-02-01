<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function product()
    {
        return $this->belongsToMany('App\Product','product_sale');    }
}
