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
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_type_person')->unsigned();
            $table->foreign('id_type_person')->references('id')->on('types_of_persons');
            $table->string('full_name');
            $table->integer('id_type_document')->unsigned();
            $table->foreign('id_type_document')->references('id')->on('types_of_documents');
            $table->string('document')->unique();
            $table->integer('cellphone');
            $table->string('email');
            $table->string('address')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('customers');
    }
};
