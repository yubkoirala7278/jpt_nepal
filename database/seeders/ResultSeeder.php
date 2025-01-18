<?php

namespace Database\Seeders;

use App\Models\Result;
use App\Models\Students;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Fetch all eligible students
        $students = Students::where('status', true)
            ->whereNotNull('exam_number')
            ->whereNotNull('amount')
            ->get();

        foreach ($students as $student) {
            // Check if a result already exists for the student
            $existingResult = Result::where('student_id', $student->id)->first();

            if (!$existingResult) {
                // Generate random marks between 1 and 100
                $marks = rand(1, 100);

                // Determine result status based on marks
                $resultStatus = $marks >= 50 ? 'pass' : 'fail';

                // Insert result
                Result::create([
                    'student_id' => $student->id,
                    'result' => $resultStatus,
                    'marks' => $marks,
                ]);

                echo "Result added for Student ID: {$student->id}, Marks: {$marks}, Result: {$resultStatus}\n";
            } else {
                echo "Result already exists for Student ID: {$student->id}\n";
            }
        }
    }
}
