<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // default password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * State for test_center_manager role
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function testCenterManager()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('test_center_manager');
        });
    }

    /**
     * State for consultancy_manager role
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function consultancyManager()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('consultancy_manager');
        });
    }
}
