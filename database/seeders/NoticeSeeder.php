<?php

namespace Database\Seeders;

use App\Models\Notice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Use faker to generate 50 notices
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            // Generate random notice data
            $title = $faker->sentence(6); // Random title with 6 words

            Notice::create([
                'title' => $title,
                'image' => 'Storage/notice/678a14f6aa94b.jpeg', // Fixed image path
                'description' => $faker->paragraph(5), // 5 sentences description
                'author_name' => $faker->name, // Random author name
            ]);
        }
    }
}
