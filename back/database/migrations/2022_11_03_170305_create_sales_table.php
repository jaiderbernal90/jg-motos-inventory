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
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reference')->unique();
            $table->integer('id_customer')->unsigned();
            $table->foreign('id_customer')->references('id')->on('customers')->onDelete('cascade');
            $table->integer('id_payment_method')->unsigned();
            $table->foreign('id_payment_method')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->integer('status');
            $table->integer('total_bails')->nullable();
            $table->integer('subtotal');
            $table->integer('tax');
            $table->integer('total');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
