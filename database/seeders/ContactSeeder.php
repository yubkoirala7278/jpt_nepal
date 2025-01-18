<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Use faker to generate 50 contacts
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            // Generate random contact data
            $name = $faker->name;

            Contact::create([
                'name' => $name,
                'email' => $faker->unique()->safeEmail, // Random unique email
                'phone' => $faker->phoneNumber, // Random phone number
                'message' => $faker->paragraph(3), // Random 3-sentence message
            ]);
        }
    }
}
