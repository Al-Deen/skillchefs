<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class TransactionExport implements FromCollection, WithHeadings, WithEvents
{

    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->transactions->map(function ($transaction) {
            return [
                $transaction->id,
                @$transaction->account->ac_name,
                $transaction->status->name,
                @$transaction->status_id == 27 ? '- ' : '+ ' . showPrice(@$transaction->amount),
                showDate(@$transaction->created_at),
            ];
        });
    }

    public function headings(): array
    {
        return [
            ___('common.SL'),
            ___('account.Account_Name'),
            ___('common.type'),
            ___('common.Amount'),
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
