<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function sale()
    {
        return $this->hasMany('App\Sale');
    }
    public function paymentGateway()
    {
        return $this->belongsTo('App\PaymentGateway');
    }
}
