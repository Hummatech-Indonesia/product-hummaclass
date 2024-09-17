<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseTask;
use App\Models\Module;
use App\Models\ModuleQuestion;
use App\Models\ModuleTask;
use App\Models\Quiz;
use App\Models\SubmissionTask;
use App\Models\SubModule;
use Faker\Provider\Uuid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $course = Course::create([
            'id' => Uuid::uuid(),
            'sub_category_id' => 1,
            'title' => 'lorem ipsum',
            'slug' => Str::slug('lorem ipsum'),
            'sub_title' => 'lorem ipsum dolor sit amet',
            'description' => 'lorem ipsum dolor sit amet lorem rebum magna diam stet',
            'price' => 100000,
            'is_premium' => true,
        ]);

        $module = Module::create([
            'id' => Uuid::uuid(),
            'course_id' => $course->id,
            'step' => 1,
            'title' => 'lorem ipsum',
            'slug' => Str::slug('lorem ipsum'),
            'sub_title' => 'lorem ipsum dolor sit amet'
        ]);
        $module = Module::create([
            'id' => Uuid::uuid(),
            'course_id' => $course->id,
            'step' => 2,
            'title' => 'lorem ipsum second',
            'slug' => Str::slug('lorem ipsum second'),
            'sub_title' => 'lorem ipsum dolor sit amet'
        ]);
        SubModule::create([
            'id' => Uuid::uuid(),   
            'module_id' => $module->id,
            'step' => 1,
            'title' => 'lorem ipsum',
            'slug' => Str::slug('lorem ipsum'),
            'sub_title' => 'lroem ipsum dolor sit amet',
            'content' => "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).",
            'url_youtube' => 'https://youtu.be/_3fQQdLyVec?si=OtNDQyJ2EKfw1Aqo'
        ]);

        ModuleQuestion::create([
            'id' => Uuid::uuid(),
            'module_id' => $module->id,
            'question' => 'lorem ipsum dolor sit amet',
            'option_a' => 'lorem ipsum',
            'option_b' => 'lorem ipsum',
            'option_c' => 'lorem ipsum',
            'option_d' => 'lorem ipsum',
            'option_e' => 'lorem ipsum',
            'answer' => 'lorem ipsum is simply dummy text',
        ]);
        Quiz::create([
            'id' => Uuid::uuid(),
            'module_id' => $module->id,
            'title' => 'lorem ipsum dolor sit amet',
            'slug' => Str::slug('lorem ipsum dolor sit amet'),
            'total_question' => 10
        ]);
        $moduleTask = ModuleTask::create([
            'id' => Uuid::uuid(),
            'module_id' => $module->id,
            'number_of' => 1,
            'question' => 'lorem ipsum dolor sit amet'
        ]);
    }
}
