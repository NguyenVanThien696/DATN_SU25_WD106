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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('password');
            $table->text('address')->nullable()->after('phone');
            $table->enum('gender', ['male', 'female', 'other'])->default('other')->after('address');
            $table->enum('role', ['customer', 'admin'])->default('customer')->after('gender');
            $table->string('avatar', 255)->nullable()->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address', 'gender', 'role', 'avatar']);
        });
    }
};
