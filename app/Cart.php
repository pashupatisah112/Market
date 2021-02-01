<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function product()
    {
        return $this->belongsToMany('App\Product','cart_products');
    }
    public function color()
    {
        return $this->belongsTo('App\Color');
    }
    public function size()
    {
        return $this->belongsTo('App\Size');
    }
}
