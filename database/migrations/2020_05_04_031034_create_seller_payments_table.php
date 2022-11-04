<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_payments', function (Blueprint $table) {
            $table->increments('prod_payment_id');
            $table->integer('payment_prod_id');
            $table->text('payment_prod_title');
            $table->integer('payment_sellr_id');
            $table->decimal('payment_amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_payments');
    }
}
