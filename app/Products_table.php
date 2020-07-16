<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products_table extends Model
{
    protected $table = 'products_table';
    protected $fillable = [ 'name_product', 'sku', 'description', 'price'];


    public function carts_of_a_product()
    {
        return $this->belongsToMany('App\Products_carts_table', 'products_table', 'id', 'product_id');
    }

}

