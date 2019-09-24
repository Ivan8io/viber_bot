<?php

namespace App\Imports;

use App\DiscountCard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DiscountCardsImport implements ToModel, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DiscountCard([
            //
            'phone' => $row[1],
            'ean' => $row[2],
            'bonuses' => $row[3],
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
