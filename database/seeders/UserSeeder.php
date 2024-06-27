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
                'course_id' => null,
                'section_id' => null
            ],
            [
                'name' => 'Panelist One',
                'email' => 'panelist1@example.com',
                'email_verified_at' => now(),
                'role' => 'panelist',
                'course_id' => null,
                'section_id' => null
            ],
            [
               'name' => 'Panelist Two',
                'email' => 'panelist2@example.com',
                'email_verified_at' => now(),
                'role' => 'panelist',
                'course_id' => null,
                'section_id' => null
            ],
            [
               'name' => 'Panelist Three',
                'email' => 'panelist3@example.com',
                'email_verified_at' => now(),
                'role' => 'panelist',
                'course_id' => null,
                'section_id' => null
            ], 
            [
                'name' => 'Secretary Michelle',
                'email' => 'secretary@example.com',
                'email_verified_at' => now(),
                'role' => 'secretary',
                'course_id' => null,
                'section_id' => null
            ],
            [
                'name' => 'Student John Doe',
                'email' => 'johndoe@example.com',
                'email_verified_at' => now(),
                'role' => 'student',
                'course_id' => 1,
                'section_id' => 1
            ],
            [
                'name' => 'Student Will Smith',
                'email' => 'willsmith@example.com',
                'email_verified_at' => now(),
                'role' => 'student',
                'course_id' => 1,
                'section_id' => 1
            ],
            [
                'name' => 'Student Nicole Tan',
                'email' => 'nicole@example.com',
                'email_verified_at' => now(),
                'role' => 'student',
                'course_id' => 1,
                'section_id' => 1
            ]
        ];

        foreach ($users as $user) {
            $u = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => $user['email_verified_at'],
                'password' => bcrypt('password'),
                'course_id' => $user['course_id'],
                'section_id' => $user['section_id']
            ]);
    
            $u->assignRole($user['role']);
        }
    }
}
