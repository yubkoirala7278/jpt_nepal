<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class StudentsExport implements FromCollection, WithHeadings
{
    protected $applicants;
    public function __construct(Collection $applicants)
    {
        $this->applicants = $applicants;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->applicants->map(function ($student) {
            return [
                $student->id,
                $student->slug,
                $student->name,
                $student->dob,
                $student->email,
                $student->exam_date->exam_date
            ];
        });
    }
    
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'id',
            'Registration Number',
            'Name',
            'Date of Birth',
            'Email',
            'Exam Date',
            'marks',
            'result'
        ];
    }
}