<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Use faker to generate 50 blogs
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            // Generate random blog data
            $title = $faker->sentence(6); // Random title with 6 words

            Blog::create([
                'title' => $title,
                'description' => $faker->paragraph(10), // Random description with 10 sentences
                'image' => 'Storage/blog/678a1af19b7ef.jpeg', // Fixed image path
                'status' => $faker->randomElement(['active', 'inactive']), // Random status
            ]);
        }
    }
}
