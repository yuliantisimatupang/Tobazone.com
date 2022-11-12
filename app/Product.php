<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public function merchant() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function reviews() {
        return $this->hasMany('App\ProductReview');
    }

    public function review() {
        return $this->hasOne('App\ProductReview');
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }

    protected $fillable = ['name', 'price', 'stock', 'description', 'category', 'specification', 'image', 'color'];
    protected $dates = ['deleted_at'];
}
