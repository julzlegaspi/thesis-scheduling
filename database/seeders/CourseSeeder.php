<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'code' => 'BSCS',
                'name' => 'Bachelor of Science in Computer Science'
            ],
            [
                'code' => 'BSIT',
                'name' => 'Bachelor of Science in Information Technology',
            ],
            [
                'code' => 'BSIS',
                'name' => 'Bachelor of Science in Information System'
            ],
            [
                'code' => 'BLIS',
                'name' => 'Bachelor of Library and Information Science'
            ]
        ];

        foreach ($courses as $course) {
            Course::create([
                'code' => $course['code'],
                'name' => $course['name']
            ]);
        }
    }
}
