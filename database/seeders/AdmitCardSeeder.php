<?php

namespace Database\Seeders;

use App\Models\AdmitCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdmitCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // Create 100 admit cards
      AdmitCard::factory()->count(100)->create();
    }
}
