<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products_table extends Model
{
    protected $table = 'products_table';
    protected $fillable = [ 'name_product', 'sku', 'description', 'api_token'];
}
