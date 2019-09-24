<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

//use BotMan\BotMan\Storages\Storage;

Route::get('/', function () {
    //return view('welcome');

    /*

    var_dump(\App\DiscountCard::whereNotNull('msguser_id'));

    $barcodeGenerator = new \Picqer\Barcode\BarcodeGeneratorJPG();
    $barcodeImg = $barcodeGenerator->getBarcode('7000000772795', $barcodeGenerator::TYPE_CODE_128, '5', '100');

    //Storage:: putFileAs('photos', new File(storage_path('app/public')), 'file.jpg');

    Storage::disk('local')->put('public/barcodeImg.jpg', $barcodeImg);



   // echo asset('storage/barcodeImg.jpg');

    //echo '<img src="data:image/png;base64,' . base64_encode($barcodeGenerator->getBarcode('081231723897', $barcodeGenerator::TYPE_EAN_13)) . '">';
    $img = Image::make('storage/card_base.png')->insert('storage/barcodeImg.jpg', 'top-left', 250, 420)->save('storage/bar.jpg');
    echo(' <img src = '. $img->basePath() . '>');

    echo($img->basePath());

    //echo url();
    */
});


Route::get('/xls', function () {
    //return view('welcome');

    /*
    \App\XlsWrapper::UpdateDicsountsFromXLS();

    echo('Done');

    $cards = Excel::toArray(new \App\Imports\DiscountCardsImport(), storage_path('app/public/cards.xls'));

    foreach ($cards[0] as $card)
    {
        if($card[0] != '№') {

            $dCard = \App\DiscountCard::firstOrCreate([
                'phone' => $card[1],
                'ean' => $card[2],
                //'bonuses' => $card[3] == null ? 0 : $card[3],
            ]);

            if($card[3] == null)
            {
                $dCard->bonuses = 0;
            }
            elseif ($card[3] < 0)
            {
                $b = abs($card[3]);
                $dCard->bonuses = $b;
            }
            else
            {
                $dCard->bonuses = $card[3];
            }

            $dCard->save();

            //$dCard->bonuses = $card[3] == null ? 0 : $card[3] ;

            print_r($dCard);
            echo ('<br>');
        }
    }
    echo 'test';
    */

});


Route::match(['get', 'post'], '/botman', 'BotManController@handle');
//Route::get('/botman/tinker', 'BotManController@tinker');
Route::get('/cardsdownload', 'TableDownloadController@DownloadDiscountCards');
Route::get('/usersdownload', 'TableDownloadController@DownloadUsers');


