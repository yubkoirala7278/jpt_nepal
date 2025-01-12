<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class StudentsExport implements FromCollection, WithHeadings
{
    protected $applicants;
    protected $exportReason;

    public function __construct(Collection $applicants, $exportReason)
    {
        $this->applicants = $applicants;
        $this->exportReason = $exportReason;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->applicants->map(function ($student) {
            $row = [
                $student->email,
                $student->name,
                $student->gender,
                $student->nationality,
                $student->dob
            ];

            return $row;
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headings = [
            'Email',
            'Full Name',
            'Gender',
            'Nationality',
            'Birthdate'
        ];

        // Add additional headings based on the export reason
        if ($this->exportReason === 'exam_code') {
            $headings[] = 'Examinee Number'; // Add Examinee Number heading
        }

        if ($this->exportReason === 'result') {
            $headings[] = 'Marks';   // Add Marks heading
            $headings[] = 'Result';  // Add Result heading
        }

        return $headings;
    }
}
