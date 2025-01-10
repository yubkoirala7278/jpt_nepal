<?php

namespace App\Imports;

use App\Models\Students;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Exception;

class ExamCodeImport  implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
       
        DB::beginTransaction();

        try {
            if(!$row['exam_code']){
                throw new Exception("Please insert Exam Code in your file.");
            }
            // Find the student by email
            $student = Students::where('email', $row['email'])->first();

            if (!$student) {
                throw new Exception("No student found with email: {$row['email']}");
            }
            // Check if the student already has an exam_code
            if (!is_null($student->exam_number)) {
                throw new Exception("The student with email '{$row['email']}' already has an exam code: '{$student->exam_number}'.");
            }

            // Check if the exam_number is already assigned to another student
            $existingStudent = Students::where('exam_number', $row['exam_code'])->first();
            if ($existingStudent) {
                throw new Exception("The exam number '{$row['exam_code']}' is already assigned to another student.");
            }

            // Update the exam_number for the found student
            $student->update([
                'exam_number' => $row['exam_code'], // Replace 'exam_number' with the actual column heading in your Excel
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e; // Re-throw the exception to stop the import and handle it in the controller
        }
    }
}
