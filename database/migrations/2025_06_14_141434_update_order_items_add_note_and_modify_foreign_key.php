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
        // Thêm cột note và xoá ràng buộc cũ
        Schema::table('order_items', function (Blueprint $table) {
            $table->text('note')->nullable()->after('price');

            // Xoá foreign key cũ trước khi thêm lại
            $table->dropForeign(['product_variant_id']);
        });

        // Thêm lại foreign key với onDelete('set null')
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
            $table->dropColumn('note');
        });

        // Thêm lại foreign key mặc định (không có onDelete)
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('product_variant_id')->references('id')->on('product_variants');
        });
    }
};
