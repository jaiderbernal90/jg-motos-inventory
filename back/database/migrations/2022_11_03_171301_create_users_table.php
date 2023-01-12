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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name');
            $table->integer('id_type_document')->unsigned()->nullable();
            $table->foreign('id_type_document')->references('id')->on('types_of_documents');
            $table->string('document')->nullable()->unique();
            $table->date('date_birth')->nullable();
            $table->string('phone')->nullable();            
            $table->boolean('status');
            $table->json('avatar')->nullable();
            $table->string('email')->unique();
            $table->integer('id_role')->unsigned()->nullable();
            $table->foreign('id_role')->references('id')->on('roles')->onDelete('cascade');
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
