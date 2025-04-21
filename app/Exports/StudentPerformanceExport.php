<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class StudentPerformanceExport implements FromCollection, WithHeadings, WithStrictNullComparison, WithEvents
{

    protected $student_performances;

    public function __construct($student_performances)
    {
        $this->student_performances = $student_performances;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->student_performances->map(function ($student) {
            return [
                $student->id,
                @$student->user->name,
                @$student->points,
                @$student->enrollments->count(),
                @$student->completeEnrollments->count(),
                @$student->country->name,
                @$student->user->userStatus->name,
                showDate(@$student->created_at),
            ];
        });

    }

    public function headings(): array
    {
        return [
            ___('common.ID'),
            ___('common.Name'),
            ___('student.Point'),
            ___('student.Enroll'),
            ___('student.Course_Completed'),
            ___('common.Country'),
            ___('common.Status'),
            ___('common.Created_at'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:Q1')->getFont()->setSize(14);
            },
        ];
    }
}
