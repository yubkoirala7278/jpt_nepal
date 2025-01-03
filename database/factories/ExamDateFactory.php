<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamDate>
 */
class ExamDateFactory extends Factory
{
    protected $model = \App\Models\ExamDate::class;

    public function definition()
    {
        return [
            'exam_date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'exam_start_time' => $this->faker->time('H:i:s', '12:00'),
            'exam_end_time' => $this->faker->time('H:i:s', '18:00'),
        ];
    }
}
