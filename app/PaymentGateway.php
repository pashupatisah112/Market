<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    public function order()
    {
        return $this->hasMany('App\PaymentGateway');
    }
}
