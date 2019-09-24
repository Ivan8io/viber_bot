<?php

namespace App\Exports;

use App\DiscountCard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CardsExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DiscountCard::whereNotNull('msguser_id')->get(['phone', 'ean', 'bonuses']);
    }

    public function headings(): array
    {
        return [
            'phone',
            'ean',
            'bonuses'
        ];
    }
}
