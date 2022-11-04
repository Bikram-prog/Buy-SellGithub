<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSellerAddToSellerUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seller_users', function (Blueprint $table) {
            $table->string('seller_comp_name');
            $table->string('seller_address');
            $table->string('seller_state');
            $table->string('seller_country');
            $table->string('seller_city');
            $table->string('seller_postcode');
            $table->string('seller_contct_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seller_users', function (Blueprint $table) {
            //
        });
    }
}
