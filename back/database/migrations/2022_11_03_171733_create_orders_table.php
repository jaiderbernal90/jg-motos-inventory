<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reference')->unique();
            $table->integer('id_provider')->unsigned();
            $table->foreign('id_provider')->references('id')->on('providers')->onDelete('cascade');
            $table->boolean('statu_commodity');
            $table->boolean('payment_status');
            $table->integer('id_payment_method')->unsigned();
            $table->foreign('id_payment_method')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->integer('total_bails');
            $table->integer('subtotal');
            $table->integer('tax');
            $table->integer('total');
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
        Schema::dropIfExists('orders');
    }
};
