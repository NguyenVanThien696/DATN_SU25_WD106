<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->enum('type', ['percent', 'amount'])->default('percent')->after('code');
            $table->integer('discount_amount')->nullable()->after('discount_percent');
            $table->integer('max_discount')->nullable()->after('discount_amount');
            $table->integer('min_order_value')->default(0)->after('max_discount');
            $table->enum('status', ['active', 'inactive', 'expired'])->default('active')->after('expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['type', 'discount_amount', 'max_discount', 'min_order_value', 'status']);
        });
    }
};
