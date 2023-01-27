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
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('id_brand')->references('id')->on('brands')->onDelete('set null');
            $table->foreign('id_section')->references('id')->on('sections')->onDelete('set null');
            $table->foreign('id_column')->references('id')->on('columns')->onDelete('set null');
            $table->foreign('id_row')->references('id')->on('rows')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_id_brand_foreign');
            $table->dropForeign('products_id_section_foreign');
            $table->dropForeign('products_id_column_foreign');
            $table->dropForeign('products_id_row_foreign');
        });
    }
};
