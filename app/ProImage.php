<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProImage extends Model
{
    protected $table = 'pro_images';

    public function products(){

        return $this->belongsTo(Product::class,'prod_id','prod_img_prod_id');
         
     }
}
