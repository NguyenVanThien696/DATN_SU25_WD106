<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('pending_orders', function (Blueprint $table) {
        $table->unsignedInteger('discount')->default(0)->after('total_price');
        $table->unsignedInteger('shipping_fee')->default(0)->after('discount');
    });
}

public function down()
{
    Schema::table('pending_orders', function (Blueprint $table) {
        $table->dropColumn(['discount', 'shipping_fee']);
    });
}
};