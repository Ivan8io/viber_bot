<?php


namespace App;


use Maatwebsite\Excel\Facades\Excel;

class XlsWrapper
{
    public static function UpdateDicsountsFromXLS()
    {
        $cards = Excel::toArray(new \App\Imports\DiscountCardsImport(), storage_path('app/public/cards.xls'));

        foreach ($cards[0] as $card)
        {
            if($card[0] != '№') {

                $dCard = \App\DiscountCard::firstOrCreate([
                    'phone' => $card[1],
                    'ean' => $card[2],
                ]);

                //Если в таблице ничего нет - присваиваем 0, иначе - модуль числа
                // Модуль - потому что в таблице есть отрицательные бонусы
                $dCard->bonuses_count = $card[3] == null ? 0 : $card[3];
                $dCard->save(); // сохраняем
            }
        }
    }

}