<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products_carts_table extends Model
{
    protected $table = 'product_carts_table';
    protected $fillable = [ 'product_id', 'cart_id', 'quantity'];

    public function products_of_a_cart()
    {
        return $this->belongsToMany('App\Products_table', 'product_carts_table', 'id', 'product_id');
    }

    public function status_cart()
    {
        return $this->hasOne('App\carts_table',  'id', 'cart_id');
    }

}
