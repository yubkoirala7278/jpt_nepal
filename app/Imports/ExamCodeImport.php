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
            if(!$row['examinee_number']){
                throw new Exception("Please insert Exam Code in your file.");
            }
            // Find the student by email
            $student = Students::where('email', $row['email'])->first();
            
            // check if the student amount is paid of not
            if (!$student->status || !$student->amount) {
                throw new Exception("The student with email '{$row['email']}' has not completed the required payment or their status is inactive.");
            }

            if (!$student) {
                throw new Exception("No student found with email: {$row['email']}");
            }
            // Check if the student already has an examinee_number
            if (!is_null($student->exam_number)) {
                throw new Exception("The student with email '{$row['email']}' already has an exam code: '{$student->exam_number}'.");
            }

            // Check if the exam_number is already assigned to another student
            $existingStudent = Students::where('exam_number', $row['examinee_number'])->first();
            if ($existingStudent) {
                throw new Exception("The exam number '{$row['examinee_number']}' is already assigned to another student.");
            }

            // Update the exam_number for the found student
            $student->update([
                'exam_number' => $row['examinee_number'], // Replace 'exam_number' with the actual column heading in your Excel
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e; // Re-throw the exception to stop the import and handle it in the controller
        }
    }
}
