<?php

namespace App\Orchid\Screens;

use App\DiscountCard;
use App\Exports\CardsExport;
use App\Orchid\Layouts\DiscountCardListLayout;
use Maatwebsite\Excel\Facades\Excel;
use Orchid\Screen\Link;
use Orchid\Screen\Screen;

class DiscountsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Карты';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Спиоск карт, ассоциированных с пользователем';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'cards' => DiscountCard::whereNotNull('msguser_id')->get(),
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Link::name('Выгрузить карты')
                ->link('http://bizarro.botgrid.net/cardsdownload')
                ->icon('icon-bag'),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            DiscountCardListLayout::class
        ];
    }

    public function cardsDownload()
    {
        $headers = array(
            'Content-type: application/download',
        );

        return Excel::download(new CardsExport, 'cards.xls', \Maatwebsite\Excel\Excel::XLS, [
            'Content-Type' => 'application/vnd.ms-excel',
            //'Content-Type' => 'application/download',
            //'Content-Type' => 'application/force-download',
            'Content-Disposition' => "attachment; filename='cards.xls'"
        ]);
    }
}
