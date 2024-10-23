<?php

namespace Database\Seeders;

use App\Models\Reward;
use Faker\Provider\Uuid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reward::create([
            'id' => Uuid::uuid(),
            'image' => '',
            'name' => 'lorem ipsum',
            'slug' => 'lorem-ipsum',
            'description' => 'lorem ipsum dolor sit amet',
            'points_required' => 10
        ]);
    }
}
