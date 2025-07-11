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
        DB::statement("
            ALTER TABLE orders 
            MODIFY status ENUM(
                'pending',
                'confirmed',
                'processing',
                'shipping',
                'delivered',
                'completed',
                'cancelled',
                'cancelled_paid',
                'refunded',
                'delivery_failed'
            ) DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE orders 
            MODIFY status ENUM(
                'pending',
                'processing',
                'completed',
                'cancelled'
            ) DEFAULT 'pending'
        ");
    }
};