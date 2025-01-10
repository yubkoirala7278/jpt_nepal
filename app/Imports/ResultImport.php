<?php

namespace App\Imports;

use App\Models\AdmitCard;
use App\Models\Result;
use App\Models\Students;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class ResultImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        DB::beginTransaction(); // Start transaction

        try {
            // Validate 'marks': Must be a number >= 0
            if (!is_numeric($row['marks']) || $row['marks'] < 0) {
                throw new \Exception("Invalid marks value for email " . $row['email'] . ". Marks must be a number >= 0.");
            }

            // Validate 'results': Must be either 'pass' or 'fail'
            if (!in_array(strtolower($row['results']), ['pass', 'fail'])) {
                throw new \Exception("Invalid results value for email " . $row['email'] . ". Results must be 'pass' or 'fail'.");
            }

            // Find the student based on email and conditions
            $student = Students::where('email', $row['email'])
                ->where('status', true)
                ->whereNotNull('exam_number')
                ->whereNotNull('amount')
                ->first();

            if (!$student) {
                throw new \Exception("Student not found with email " . $row['email']);
            }

            // Check if a result already exists for the student
            $existingResult = Result::where('student_id', $student->id)->first();

            if ($existingResult) {
                throw new \Exception("Result has already been inserted for student with email: " . $row['email']);
            }

            // Create the result entry
            $result = new Result([
                'student_id' => $student->id,
                'result' => strtolower($row['results']), // Save as lowercase (standard format)
                'marks' => $row['marks'],
            ]);

            $result->save();

            DB::commit(); // Commit the transaction

            return $result;
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on error

            // Optionally, log the error or rethrow the exception
            throw new \Exception("Error importing row for email " . $row['email'] . ": " . $e->getMessage());
        }
    }
}
