<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;

class DiscountCardListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $data = 'cards';

    /**
     * @return TD[]
     */
    public function fields(): array
    {
        return [
            //TD::set('created_at','Зарегистрирован'),
            TD::set('ean', 'EAN'),
            TD::set('phone', 'Номер телефона'),
            TD::set('bonuses_count', 'Бонусы'),
        ];
    }
}
