<?php

namespace Database\Factories;

use App\Models\Result;
use App\Models\Students;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Result>
 */
class ResultFactory extends Factory
{
    protected $model = Result::class;

    public function definition()
    {
        // Find a student who fulfills the criteria and doesn't already have a result
        $student = Students::where('status', true)
            ->whereNotNull('exam_number')
            ->whereNotNull('amount')
            ->whereDoesntHave('result') // Ensure the student doesn't already have a result
            ->inRandomOrder()
            ->first();

        // If no valid student is found, skip factory generation
        if (!$student) {
            throw new \Exception("No valid student found to generate a result.");
        }

        return [
            'student_id' => $student->id,
            'result' => $this->faker->randomElement(['pass', 'fail']), // Random result (pass or fail)
            'marks' => $this->faker->randomFloat(2, 0, 100), // Marks between 0 and 100
        ];
    }
}
