<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Attendance;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // デモ用ダミーアカウントを作成
        User::create([
    'name' => 'デモユーザー1',
    'email' => 'demo1@example.com',
    'email_verified_at' => now(),
    'password' => bcrypt('password'),
]);

User::create([
    'name' => 'デモユーザー2',
    'email' => 'demo2@example.com',
    'email_verified_at' => now(),
    'password' => bcrypt('password'),
]);

User::create([
    'name' => 'デモユーザー3',
    'email' => 'demo3@example.com',
    'email_verified_at' => now(),
    'password' => bcrypt('password'),
]);

        \App\Models\User::factory(7)->create();
        $this->call(AttendancesTableSeeder::class);
    }
}
