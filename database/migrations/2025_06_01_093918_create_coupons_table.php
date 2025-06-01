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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->integer('discount_percent');
            $table->dateTime('expires_at')->nullable();
        });

        // Thêm CHECK constraint cho discount_percent từ 1 đến 100
        DB::statement('ALTER TABLE coupons ADD CONSTRAINT chk_discount_percent CHECK (discount_percent BETWEEN 1 AND 100)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
