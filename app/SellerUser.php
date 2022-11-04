<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerUser extends Model
{
    protected $table = 'seller_users';

    public function products(){

        return $this->hasMany(Product::class,'prod_seller_id','s_id');

    }
}
