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
        Schema::create('pending_orders', function (Blueprint $table) {
        $table->id();
        $table->string('txn_ref')->unique(); // Lưu vnp_TxnRef
        $table->unsignedBigInteger('user_id');
        $table->text('note')->nullable();
        $table->json('user_info');
        $table->json('cart_items');
        $table->integer('total_price');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_orders');
    }
};