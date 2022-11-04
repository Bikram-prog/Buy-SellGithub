<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyer_addresses', function (Blueprint $table) {
            $table->bigIncrements('buyer_del_id');
            $table->integer('buyer_del_add_buy_id');
            $table->string('buyer_del_address');
            $table->string('buyer_del_country');
            $table->string('buyer_del_city');
            $table->string('buyer_del_state');
            $table->string('buyer_del_postcode');
            $table->timestamp('buyer_del_add_date_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyer_addresses');
    }
}
