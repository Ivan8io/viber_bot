<?php
use App\Http\Controllers\BotManController;
use App\KeyboardMaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use TheArdent\Drivers\Viber\ViberDriver;

$botman = resolve('botman');

/*
 *  СОБЫТИЕ НАЧАЛА ДИАЛОГА - ПРОИСХОДИТ ПРИ ПЕРВОМ ВОЗДЕЙСТВИИ ПОЛЬЗОВАТЕЛЯ В БОТЕ
 *
 *
 *
 *
 * */
$botman->on('conversation_started', function($payload, $bot) {

    try
    {
        $kb = new \TheArdent\Drivers\Viber\Extensions\KeyboardTemplate('Клава');
        $kb->addButton("<font color='#FFFFFF'>Подружиться с ботом</font>",
                       'share-phone',
                       'bind_phone_number',
                       'large',
                       '#ec6608',
                       '6',
                       'true');

        //$bot->reply('Здравствуйте, меня зовут BizzarroBot krsk. Я здесь, чтобы помогать Вам!', $kb->jsonSerialize());

        $last_message = "Здравствуйте, меня зовут BizzarroBot krsk. Я здесь, чтобы помогать Вам!
                        \n\n\nВот наши соц. сети, подпишитесь и будьте в курсе всех новинок и акций.
                        \nhttps://www.instagram.com/bizzarro_outlet_krsk
                        \nhttps://vk.com/bizzarro.outlet24
                        \nА еще, мои друзья получают рассылку раньше остальных.";

        $bot->reply($last_message, $kb->jsonSerialize());
    }
    catch(Exception $ex)
    {
        Log::error($ex->getMessage());
    }

});

/*
 * СОБЫТИЕ ПОЛУЧЕНИЯ НОМЕРА ОТ ЮЗЕРА
 * ToDo
 *
 * */

$botman->hears('bind_phone_number', function ($bot) {

    $payload = $bot->getMessage()->getPayload();

    //Тут получаем нужную инфу
    $phone = $payload->get('message')['contact']['phone_number'];   //получаем номер телефона девайса
    $viberId = $payload->get('sender')['id'];                       //получаем ВайберАйДи
    $viberName = $payload->get('sender')['name'];                   //получаем имя юзера в Вайбер

    //Тут добавляем юзера в таблицу
    $user = \App\MsgUser::firstOrCreate([
        'viber_id' => $viberId,
        'username' => $viberName,
    ]);

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Подгоняем телефон к единому формату
    //ToDo - вынести в отдельную фун-ию всю эту хрень

    $phone = preg_replace('![^0-9]+!', '', $phone);

    if($phone[0] == 3){
        $phone = substr($phone, 1);
    } else if ($phone[0] == 7){
        $phone[0] = 8;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Сохраняем телефон отдельно
    $user->phone = $phone; //Обновляем номер телефона, буде юзер уже когда-то был
    $user->save(); //Сохраняем

    $cards = \App\DiscountCard::where('phone', $phone)->get(); //выясняем есть ли карты с таким номером телефона
    $cards_count = count($cards); //Считаем кол-во найденных карт

    if($cards_count > 0)
    {
        $user->is_found = true; //Отмечаем, что юзер найден
        $user->save();
        $bot->reply('Я узнал Вас, чем могу быть полезен?', \App\KeyboardMaker::GetMainViberKeyboard());

        foreach ($cards as $card){
            $card->msguser_id = $user->id;
            $card->save();
        }
    }
    else
    {
        $kb = new \TheArdent\Drivers\Viber\Extensions\KeyboardTemplate('Клава');
        $kb->addButton("<font color='#FFFFFF'>Подружиться с ботом</font>", 'share-phone', 'bind_phone_number', 'large', '#ec6608', '6', 'false');
        $bot->reply('К сожалению, номер '.
            substr_replace($phone, '******', 1, 6).
            ' не найден в нашей базе. Обратитесь к сотрудникам магазина.', $kb->jsonSerialize());
    }

});


/**
 * ОБРАБОТКА ПОЛУЧЕНИЯ КАРТЫ
 *
 *
 */
$botman->hears('my_card', function ($bot) {

    try
    {
        $payload = $bot->getMessage()->getPayload();
        $viberId = $payload->get('sender')['id']; //Получаем ВайберАйДи

        $vu = \App\MsgUser::where('viber_id', $viberId)->first();

        $vId = $vu->id; //ID юзера в базе

        $cards = \App\DiscountCard::where('msguser_id', $vId)->get();

        foreach ($cards as $card)
        {
            $url = \App\DiscoundCardMaker::MakeCardImage($card->ean);
            $cardNumber = substr($card->ean, 6, 6);

            $img = new \TheArdent\Drivers\Viber\Extensions\PictureTemplate(
                $url,
                $cardNumber,
                $url);

            $bot->reply($img, \App\KeyboardMaker::GetMainViberKeyboard());
        }

        //\App\Jobs\ProcessPromoMessage::dispatch($viberId); //Отправка сервисного сообщения


    }
    catch (Exception $ex)
    {
        \Illuminate\Support\Facades\Log::error($ex->getMessage());
    }
});

$botman->hears('bonuses', function ($bot) {

    $payload = $bot->getMessage()->getPayload();
    $viberId = $payload->get('sender')['id']; //Получаем ВайберАйДи

    $vu = \App\MsgUser::where('viber_id', $viberId)->first();
    $vId = $vu->id; //ID юзера в базе

    $cards = \App\DiscountCard::where('msguser_id', $vId)->get();

    foreach ($cards as $card)
    {
        $cardNumber = substr($card->ean, 6, 6);
        $message = "Карта ".$cardNumber." \nВаши бонусы: ".number_format($card->bonuses_count, 2, ',', ' ')." руб.\n";
        $bot->reply($message, \App\KeyboardMaker::GetMainViberKeyboard());
    }

});

$botman->fallback(function($bot) {
    try {
        $bot->reply("Простите, но я Вас не понимаю...\nВы можете воспользоваться клавиатурой ниже", \App\KeyboardMaker::GetMainViberKeyboard());
    }
    catch (Exception $ex){
        \Illuminate\Support\Facades\Log::error($ex->getMessage());
    }
});

$botman->hears('разработчик|кто тебя сделал|who is your daddy|кто тебя создал|ктотвой создатель|кто разработал', function ($bot) {
    $bot->reply('https://botmakers.pro', \App\KeyboardMaker::GetMainViberKeyboard());
});