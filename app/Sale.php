<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function size()
    {
        return $this->belongsTo('App\Size');
    }
    public function color()
    {
        return $this->belongsTo('App\Color');
    }
    public function order(){
        return $this->belongsTo('App\Order');
    }
}
