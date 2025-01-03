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
        // Generate marks, and determine result based on marks
        $marks = $this->faker->numberBetween(0, 100);
        $result = $marks < 30 ? 'fail' : 'pass'; // Marks below 30 will be fail, otherwise pass

        return [
            'result' => $result,
            'marks' => $marks,
            'student_id' => function () {
                // Get students with status true who do not already have a result
                $student = Students::where('status', true)
                    ->whereDoesntHave('results') // Ensure the student doesn't already have a result
                    ->inRandomOrder()
                    ->first();

                return $student ? $student->id : null; // Return student id if found, else return null
            },
        ];
    }
}
