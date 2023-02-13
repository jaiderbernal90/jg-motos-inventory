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
        Schema::table('audit_orders', function (Blueprint $table) {
            $table->integer('type')->comment('1 -> create // 2 -> update // 3 -> delete // 4 -> add bails // 5 -> delete bails')->change();
            $table->integer('id_bail_order')->nullable()->unsigned();
            $table->foreign('id_bail_order')->references('id')->on('bails_orders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_orders', function (Blueprint $table) {
            $table->integer('type')->comment('1 -> create // 2 -> update // 3 -> delete')->change();
            $table->dropForeign('audit_orders_id_bail_order_foreign');
            $table->dropColumn('id_bail_order');
        });
    }
};
