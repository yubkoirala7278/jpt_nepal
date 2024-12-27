<?php

namespace App\Imports;

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
        // Assuming your Excel file has columns like name, email, and password
        return new Result([
            'student_id' => $row['id'],
            'result'=>$row['result'],
            'marks'=>$row['marks']
        ]);
    }
}
