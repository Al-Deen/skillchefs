<?php

namespace Modules\Event\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class EventReportExport implements FromCollection, WithHeadings, WithEvents
{

    protected $events;

    public function __construct($events)
    {
        $this->events = $events;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->events)->map(function ($events) {
            return [
                @$events->title,
                @$events->event_type,
                @$events->category->title,
                @$events->isPaid(),
                showDate(@$events->start).' - '.showDate(@$events->end),
                @$events->register->count(),
                showPrice(@$events->register_income[0]->income),
                $events->status->name,
            ];
        });
    }

    public function headings(): array
    {
        return [
            ___('event.Event Title'),
            ___('event.Event Type'),
            ___('event.Category'),
            ___('event.Ticket Price'),
            ___('event.Event Duration'),
            ___('event.Total Registered'),
            ___('event.Total Income'),
            ___('event.Status'),
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
