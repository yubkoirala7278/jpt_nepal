<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use faker to generate 50 testimonials
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            // Generate random testimonial data
            $name = $faker->name;

            Testimonial::create([
                'name' => $name,
                'description' => $faker->paragraph(3), // 3 sentences description
                'status' => $faker->boolean(80), // 80% chance of being true
            ]);
        }
    }
}
