<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class StudentExport implements FromCollection, WithHeadings, WithStrictNullComparison, WithEvents
{

    protected $student;

    public function __construct($student)
    {
        $this->student = $student;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->student)->map(function ($student) {
            return [
                $student->id,
                @$student->user->name,
                @$student->points ?? 0,
                @$student->enrollments->count() ?? 0,
                $student->user->userStatus->name,
                showDate(@$student->created_at),
            ];
        });
    }

    public function headings(): array
    {
        return [
            ___('common.ID'),
            ___('common.Name'),
            ___('common.Point'),
            ___('common.Enroll'),
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
