<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->enum('discount_type', ['percent', 'amount'])->default('percent')->after('code');
            $table->integer('discount_amount')->nullable()->after('discount_percent');

            $table->dateTime('start_at')->nullable()->after('expires_at');
            $table->dateTime('end_at')->nullable()->after('start_at');

            $table->integer('usage_limit')->nullable()->after('end_at');
            $table->integer('used')->default(0)->after('usage_limit');

            $table->enum('status', ['active', 'inactive', 'expired'])->default('active')->after('used');
        });

        // Ràng buộc kiểm tra discount_percent từ 1 đến 100 (nếu chưa có)
        DB::statement('ALTER TABLE coupons DROP CONSTRAINT IF EXISTS chk_discount_percent');
        DB::statement('ALTER TABLE coupons ADD CONSTRAINT chk_discount_percent CHECK (discount_percent BETWEEN 1 AND 100)');

        // Ràng buộc discount_amount >= 0
        DB::statement('ALTER TABLE coupons ADD CONSTRAINT chk_discount_amount CHECK (discount_amount IS NULL OR discount_amount >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn([
                'discount_type',
                'discount_amount',
                'start_at',
                'end_at',
                'usage_limit',
                'used',
                'status',
            ]);
        });

        DB::statement('ALTER TABLE coupons DROP CONSTRAINT IF EXISTS chk_discount_amount');
        DB::statement('ALTER TABLE coupons DROP CONSTRAINT IF EXISTS chk_discount_percent');
    }
};