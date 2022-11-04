<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = false;

    public function seller_users(){

        return $this->belongsTo(SellerUser::class,'s_id','prod_seller_id');
        
    }

    public function product_images(){

        return $this->hasMany(ProImage::class,'prod_img_prod_id','prod_id');

    }

    public function product_image(){

        return $this->hasOne(ProImage::class,'prod_img_prod_id','prod_id')->withDefault(['prod_default_status' => 1]);

    }
}
