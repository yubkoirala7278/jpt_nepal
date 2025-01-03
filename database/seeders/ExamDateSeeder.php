<?php

namespace Database\Seeders;

use App\Models\ExamDate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExamDate::factory()->count(100)->create();
    }
}
