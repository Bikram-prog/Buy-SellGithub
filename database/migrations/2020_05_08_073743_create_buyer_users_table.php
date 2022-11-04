<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyer_users', function (Blueprint $table) {
            $table->bigIncrements('buyer_id');
            $table->string('buyer_f_name');
            $table->string('buyer_email')->unique();
            $table->string('buyer_password');
            $table->string('buyer_sex');
            $table->timestamp('buyer_date_time');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyer_users');
    }
}
