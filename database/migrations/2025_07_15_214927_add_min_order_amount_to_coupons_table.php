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
        Schema::table('coupons', function (Blueprint $table) {
            $table->decimal('min_order_amount', 10, 2)->nullable()->after('max_discount_amount');
        });
    }


    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('min_order_amount');
        });
    }
};