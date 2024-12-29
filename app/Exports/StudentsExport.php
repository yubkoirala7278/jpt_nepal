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
                $student->exam_date->exam_date,
                 $student->status == 1 ? 'Approved' : 'Pending'
            ];
        });
    }
    
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'applicant_id',
            'registration_number',
            'applicant_name',
            'applicant_dob',
            'applicant_email',
            'applicant_exam_date',
            'applicant_status',
            'applicant_marks',
            'applicant_result',
        ];
    }
}
