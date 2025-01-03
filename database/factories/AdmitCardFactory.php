<?php

namespace Database\Factories;

use App\Models\Students;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdmitCard>
 */
class AdmitCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'admit_card' => 'Storage/admit_card/67779446ad674.webp',
            'student_id' => Students::where('status', true)->inRandomOrder()->first()->id, // Select a student with status = true
        ];
    }
}
