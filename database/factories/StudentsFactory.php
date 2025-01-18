<?php

namespace Database\Factories;

use App\Models\ExamDate;
use App\Models\Students;
use App\Models\TestCenter;
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
        // List of examinee categories
        $examineeCategories = ['Student', 'General'];

        // List of exam categories
        $examCategories = ['Regular period', 'Any time'];

        // Fetch a random test center
        $testCenter = TestCenter::inRandomOrder()->first();

        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'amount' => $this->faker->randomFloat(2, 100, 1000), // Random amount between 100 and 1000
            'profile' => 'Storage/profile/6777904f55546.jpg',
            'phone' => $this->faker->numerify('98########'), // Nepalese phone number format
            'dob' => $this->faker->date('Y-m-d', '2005-12-31'), // Random DOB before 2005
            'email' => $this->faker->unique()->safeEmail,
            'is_appeared_previously' => $this->faker->boolean,
            'receipt_image' => 'Storage/receipt_image/6777909ad774c.webp',
            'citizenship' => 'Storage/citizenship/6777904f58a77.jpg',
            'user_id' => User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['consultancy_manager', 'test_center_manager']);
            })->inRandomOrder()->first()->id,
            'exam_date_id' => ExamDate::inRandomOrder()->first()->id,
            'status' => $this->faker->boolean,
            'is_viewed_by_test_center_manager' => $this->faker->boolean,
            'is_viewed_by_admin' => $this->faker->boolean,
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'nationality' => 'Nepali',
            'exam_number' => $this->faker->numerify('EXAM-###'), // Generate random exam number
            'examinee_category' => $this->faker->randomElement($examineeCategories),
            'exam_category' => $this->faker->randomElement($examCategories),
            'test_venue' => $testCenter->test_venue ?? 'Default Venue',
            'venue_code' => $testCenter->venue_code ?? 'VENUE-001',
            'venue_name' => $testCenter->venue_name ?? 'Default Name',
            'venue_address' => $testCenter->venue_address ?? 'Default Address',
        ];
    }
}
