<?php

namespace App\Imports;

use App\Models\AdmitCard;
use App\Models\Result;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResultImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $existingResult = Result::where('student_id', $row['applicant_id'])->first();
        $existingAdmitCard = AdmitCard::where('student_id', $row['applicant_id'])->first();
        if ($existingResult) {
            throw new \Exception("Duplicate student ID found: " . $row['applicant_id']);
        }
        if (!$existingAdmitCard) {
            throw new \Exception("Admit Card Not Available of id: " . $row['applicant_id']);
        }
        // Assuming your Excel file has columns like name, email, and password
        return new Result([
            'student_id' => $row['applicant_id'],
            'result' => $row['applicant_result'],
            'marks' => $row['applicant_marks']
        ]);
    }
}
