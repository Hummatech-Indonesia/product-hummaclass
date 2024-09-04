<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'sub_category_id' => 1,
            'title' => 'lorem ipsum',
            'sub_title' => 'lorem ipsum dolor sit amet',
            'description' => 'lorem ipsum dolor sit amet lorem rebum magna diam stet',
            'price' => 100000,
            'is_premium' => true,
        ]);
    }
}
