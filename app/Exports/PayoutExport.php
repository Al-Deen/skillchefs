<?php

namespace App\Exports;


use Modules\Instructor\Entities\Payout;
use Maatwebsite\Excel\Concerns\FromCollection;

class PayoutExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Payout::all();
    }
}
