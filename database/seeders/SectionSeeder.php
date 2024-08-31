<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            '3A', '3B', '3C', '3D', '4A', '4B', '4C', '4D'
        ];

        foreach ($sections as $section) {
            Section::create([
                'course_id' => 1,
                'name' => $section
            ]);
        }
    }
}
