<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;

class MsgUserListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $data = 'users';

    /**
     * @return TD[]
     */
    public function fields(): array
    {
        return [
            //TD::set('created_at','Зарегистрирован'),
            TD::set('username', 'Имя'),
            TD::set('phone', 'Номер телефона'),
            TD::set('viber_id', 'Viber ID')->sort(),
            /*TD::set('Отправить сообщение')->render(function ($user){

                return '<a href="#"> Сообщение (не активно) </a>';

            }),*/
            TD::set('viber_id','Сообщение')
                ->loadModalAsync('messageModal', 'sendMessage', 'id', 'Отправить сообщение'),
        ];
    }
}
