<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_coupons', function (Blueprint $table) {
            // Gỡ bỏ ràng buộc cũ
            $table->dropForeign(['user_id']);
            $table->dropForeign(['coupon_id']);

            // Thêm lại ràng buộc với ON DELETE CASCADE
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('coupon_id')
                ->references('id')->on('coupons')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_coupons', function (Blueprint $table) {
            // Gỡ bỏ ràng buộc có cascade
            $table->dropForeign(['user_id']);
            $table->dropForeign(['coupon_id']);

            // Thêm lại ràng buộc không có cascade (mặc định)
            $table->foreign('user_id')
                ->references('id')->on('users');

            $table->foreign('coupon_id')
                ->references('id')->on('coupons');
        });
    }
};