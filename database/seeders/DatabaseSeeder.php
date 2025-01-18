<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        	AdminSeeder::class, 
            NationalitySeeder::class,
            // factory
            ExamDateSeeder::class,
            TestCenterAndConsultancySeeder::class,
            StudentSeeder::class,
            ResultSeeder::class,
            TestimonialSeeder::class,
            NoticeSeeder::class,
            ContactSeeder::class,
            BlogSeeder::class,
            FaqsTableSeeder::class,
    	]);
    }
}
