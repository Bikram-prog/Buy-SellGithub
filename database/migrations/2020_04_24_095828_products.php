<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('prod_id');
            $table->integer('prod_cate_id');
            $table->integer('prod_sub_cate_id');
            $table->string('prod_title');
            $table->string('prod_short_desc');
            $table->text('prod_long_desc');
            $table->decimal('prod_price', 10, 2);
            $table->integer('prod_quantity');
            $table->integer('prod_seller_id');
            $table->timestamp('prod_date_time');
            $table->integer('prod_status');
        }); 

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
