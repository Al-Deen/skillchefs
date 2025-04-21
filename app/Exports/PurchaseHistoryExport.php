<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class PurchaseHistoryExport implements FromCollection, WithHeadings, WithEvents
{

    protected $enroll;

    public function __construct($enroll)
    {
        $this->enroll = $enroll;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->enroll)->map(function ($enroll) {
            return [
                $enroll->id,
                @$enroll->course->title,
                @$enroll->user->name,
                @$enroll->teacher->name,
                showPrice(@$enroll->orderItem->amount) ?? 0,
                showPrice(@$enroll->orderItem->discount_amount) ?? 0,
                showPrice(@$enroll->orderItem->total_amount) ?? 0,
                showDate(@$enroll->orderItem->created_at),
                ___('common.Paid'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            ___('common.ID'),
            ___('instructor.Course Title'),
            ___('instructor.Student'),
            ___('instructor.Instructor'),
            ___('instructor.Price'),
            ___('instructor.Discount'),
            ___('instructor.Total Amount'),
            ___('instructor.Date'),
            ___('instructor.Payment'),
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
