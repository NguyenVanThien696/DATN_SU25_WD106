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
        Schema::table('products', function (Blueprint $table) {
            // Xóa khóa ngoại
            $table->dropForeign(['variant_id']);

            // Xóa cột
            $table->dropColumn('variant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('variant_id')->nullable()->after('brand_id');
            $table->foreign('variant_id')->references('id')->on('product_variants');
        });
    }
};