<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usr = [
            [
                'name' => 'BPS',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                'status' => 'active',
            ],
            [
                'name' => 'Dinsos',
                'username' => 'user',
                'email' => 'user@gmail.com',
                'password' => bcrypt('user'),
                'role' => 'user',
                'status' => 'active',
            ],
        ];

        foreach ($usr as $v) {
            User::create([
                'name' => $v['name'],
                'username' => $v['username'],
                'email' => $v['email'],
                'password' => $v['password'],
                'role' => $v['role'],
                'status' => $v['status'],
            ]);
        }
        ;
    }
}
