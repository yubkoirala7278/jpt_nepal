<?php

namespace Database\Seeders;

use App\Models\Consultancy;
use App\Models\TestCenter;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestCenterAndConsultancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 100 TestCenters
        \App\Models\User::factory()
            ->testCenterManager()
            ->count(100)
            ->create()
            ->each(function (User $user) {
                // Create TestCenter for each user assigned the 'test_center_manager' role
                TestCenter::create([
                    'user_id' => $user->id,
                    'phone' => '1234567890',
                    'address' => 'Test Center Address for ' . $user->name,
                    'status' => 'active',
                    'disabled_reason' => null
                ]);
            });

        // Create 100 Consultancies
        \App\Models\User::factory()
            ->consultancyManager()
            ->count(100)
            ->create()
            ->each(function (User $user) {
                // Fetch a random TestCenter user to associate with the consultancy
                $testCenterUser = \App\Models\User::whereHas('roles', function ($query) {
                    $query->where('name', 'test_center_manager');
                })->inRandomOrder()->first();

                // Create Consultancy for each user assigned the 'consultancy_manager' role
                Consultancy::create([
                    'user_id' => $user->id,
                    'test_center_id' => $testCenterUser->id, // Random test center for the consultancy
                    'phone' => '0987654321',
                    'address' => 'Consultancy Address for ' . $user->name,
                    'logo' => 'Storage/Consultancy/677775d3384f8.jpeg',
                    'status' => 'active',
                    'disabled_reason' => null
                ]);
            });
    }
}
