<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carts_table extends Model
{
    protected $table = 'carts_table';
    protected $fillable = [ 'status'];

    public function Carts_table()
    {
        return $this->hasOne('App\Products_carts_table', 'cart_id', 'id');
    }

}
