<?php

namespace Database\Factories;

use App\Models\ExamDate;
use App\Models\Students;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Students>
 */
class StudentsFactory extends Factory
{
    protected $model = Students::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'amount' => $this->faker->randomFloat(2, 100, 1000), // Random amount between 100 and 1000
            'profile' => 'Storage/profile/6777904f55546.jpg',
            'phone' => $this->faker->phoneNumber,
            'dob' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail,
            'is_appeared_previously' => $this->faker->boolean,
            'receipt_image' => 'Storage/receipt_image/6777909ad774c.webp',
            'citizenship' => 'Storage/citizenship/6777904f58a77.webp',
            'user_id' => User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['consultancy_manager', 'test_center_manager']);
            })->inRandomOrder()->first()->id,
            'exam_date_id' => ExamDate::inRandomOrder()->first()->id,
            'status' => $this->faker->boolean,
            'is_viewed_by_test_center_manager' => $this->faker->boolean,
            'is_viewed_by_admin' => $this->faker->boolean,
        ];
    }
}
