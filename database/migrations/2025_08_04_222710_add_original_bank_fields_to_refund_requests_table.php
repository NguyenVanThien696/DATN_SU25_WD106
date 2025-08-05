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
    Schema::table('refund_requests', function (Blueprint $table) {
        $table->string('original_bank_name')->nullable();
        $table->string('original_account_number')->nullable();
        $table->string('original_account_name')->nullable();
    });
}

public function down(): void
{
    Schema::table('refund_requests', function (Blueprint $table) {
        $table->dropColumn([
            'original_bank_name',
            'original_account_number',
            'original_account_name',
        ]);
    });
}
};
