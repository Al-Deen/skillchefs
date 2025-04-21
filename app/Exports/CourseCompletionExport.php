<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class CourseCompletionExport implements FromCollection, WithHeadings, WithStrictNullComparison, WithEvents
{

    protected $course_completion;

    public function __construct($course_completion)
    {
        $this->course_completion = $course_completion;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->course_completion)->map(function ($course_completion) {
            return [
                $course_completion->id,
                @$course_completion->course->title,
                @$course_completion->course->point,
                (@$course_completion->lesson_point + @$course_completion->quiz_point + @$course_completion->assignment_point),
                ___('student.Completed'),
                @$course_completion->progress . '%',
            ];
        });

    }



    public function headings(): array
    {
        return [
            ___('common.ID'),
            ___('student.Courses Title'),
            ___('student.Total Points'),
            ___('student.Points'),
            ___('student.Status'),
            ___('student.Progress'),
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
