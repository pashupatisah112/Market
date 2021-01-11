<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable=['tag_name'];//jaba ekai choti multiple data enter garinxa database ma using create
    public function product()
    {
        return $this->belongsToMany('App\Product');
    }
}
