<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
$admin = User::where('email', 'admin@email.com')->first();

if (!$admin) {
    $admin = User::create([
        'name' => 'Admin',
        'email' => 'admin@email.com',
        'role' => 1,
        'password' => bcrypt('123456'),
    ]);

    $admin->wallet()->create(['balance' => 0]);

    $this->command->info('Tài khoản Admin đã được tạo.');
} else {
    $this->command->warn('Admin đã tồn tại. Bỏ qua tạo mới.');
}
    }
}
