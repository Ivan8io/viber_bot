<?php


namespace App;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\Gd\Font;

class DiscoundCardMaker
{

    public static function MakeCardImage( $ean )
    {
        $barcodeGenerator = new \Picqer\Barcode\BarcodeGeneratorJPG();
        $barcodeImg = $barcodeGenerator->getBarcode($ean, $barcodeGenerator::TYPE_CODE_128, '5', '150');
        Storage::disk('local')->put('public/barcode'.$ean.'.jpg', $barcodeImg);

        $cardWidth = Image::make('storage/card_base.png')->width();
        $barcodeWidth = Image::make('storage/barcode'.$ean.'.jpg')->width();
        $padding = ( $cardWidth - $barcodeWidth ) / 2; //Горизонтальный отступ

        $cardNumber = substr($ean, 6, 6);

        $img = Image::make('storage/card_base.png')
            ->insert('storage/barcode'.$ean.'.jpg', 'top-left', (int)$padding, 380) //Вставка штрих-кода
            ->text($cardNumber, 700, 555, function(Font $font) {
                $font->file('storage/opensans.ttf');
                $font->size(28);
            })
            ->save('storage/'.$ean.'bar.jpg'); //Сохранение картинки

        return 'https://bizarro.botgrid.net/'.$img->basePath(); //возвращаем УРЛ картинки
    }
}