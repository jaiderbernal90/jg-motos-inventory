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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();;
            $table->text('applications')->nullable();;
            $table->string('reference')->unique();
            $table->integer('id_brand')->nullable()->unsigned();
            $table->foreign('id_brand')->references('id')->on('brands')->onDelete('cascade');
            $table->json('images')->nullable();;
            $table->integer('stock');
            $table->string('status')->nullable();
            $table->boolean('original')->nullable();
            $table->integer('stockMin')->nullable();
            $table->integer('cost');
            $table->integer('price');
            $table->integer('tax')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('price_total');
            $table->json('barcode')->nullable();
            $table->integer('id_section')->nullable()->unsigned();
            $table->foreign('id_section')->references('id')->on('sections')->onDelete('cascade');
            $table->integer('id_column')->nullable()->unsigned();
            $table->foreign('id_column')->references('id')->on('columns')->onDelete('cascade');
            $table->integer('id_row')->nullable()->unsigned();
            $table->foreign('id_row')->references('id')->on('rows')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
};
