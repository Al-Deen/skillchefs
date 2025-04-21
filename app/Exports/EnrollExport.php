<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class EnrollExport implements FromCollection, WithHeadings, WithEvents
{
    protected $enrolls;

    public function __construct($enrolls)
    {
        $this->enrolls = $enrolls;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->enrolls)->map(function ($enroll) {
            return [
                $enroll->id,
                $enroll->course->title,
                $enroll->user->name,
                showPrice($enroll->orderItem->amount),
                showPrice(@$enroll->orderItem->discount_amount),
                showPrice(@$enroll->orderItem->total_amount),
                showPrice(@$enroll->orderItem->instructor_amount),
                showDate($enroll->created_at->format('d M Y')),
            ];
        });
    }

    public function headings(): array
    {
        return [
            ___('common.ID'),
            ___('instructor.Course Title'),
            ___('instructor.Student'),
            ___('instructor.Price'),
            ___('instructor.Discount'),
            ___('instructor.Total Amount'),
            ___('instructor.Income'),
            ___('instructor.Date'),
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
