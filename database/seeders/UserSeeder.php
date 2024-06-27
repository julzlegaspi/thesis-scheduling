<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'role' => 'admin',
            ],
            [
                'name' => 'Panelist One',
                'email' => 'panelist1@example.com',
                'email_verified_at' => now(),
                'role' => 'panelist',
            ],
            [
               'name' => 'Panelist Two',
                'email' => 'panelist2@example.com',
                'email_verified_at' => now(),
                'role' => 'panelist',
            ],
            [
               'name' => 'Panelist Three',
                'email' => 'panelist3@example.com',
                'email_verified_at' => now(),
                'role' => 'panelist',
            ], [
                'name' => 'Deanna Secretary',
                'email' => 'secretary@example.com',
                'email_verified_at' => now(),
                'role' => 'secretary',
            ],
            [
                'name' => 'Student John Doe',
                'email' => 'student@example.com',
                'email_verified_at' => now(),
                'role' => 'student',
            ]
        ];

        foreach ($users as $user) {
            $u = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => $user['email_verified_at'],
                'password' => bcrypt('password'),
            ]);
    
            $u->assignRole($user['role']);
        }
    }
}
