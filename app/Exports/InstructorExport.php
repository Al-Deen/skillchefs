<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
class InstructorExport implements FromCollection, WithHeadings, WithStrictNullComparison, WithEvents
{

    protected $instructor;

    public function __construct($instructor)
    {
        $this->instructor = $instructor;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->instructor)->map(function ($instructor) {
            return [
                $instructor->id,
                @$instructor->user->name,
                @$instructor->courses->count() ?? 0,
                @$instructor->enroll->count() ?? 0,
                showPrice(@$instructor->earnings) ?? 0,
                showPrice(@$instructor->balance) ?? 0,
                $instructor->user->userStatus->name,
                showDate(@$instructor->created_at),
            ];
        });
    }

    public function headings(): array
    {
        return [
            ___('common.ID'),
            ___('common.Name'),
            ___('common.Course'),
            ___('common.Sales'),
            ___('instructor.Income'),
            ___('instructor.Balance'),
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
