<?php

namespace App\Orchid\Screens;


use App\Jobs\ProcessMassSending;
use Orchid\Screen\Fields\Button;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layout;
use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Illuminate\Http\Request;

class MassSendingScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Рассылка';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Массовая рассылка пользователям';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [

            Layout::rows([

                TextArea::make('content')
                    ->title('Текст сообщения')
                    ->required()
                    ->placeholder('Текст сообщения ...')
                    ->help('Введите текст сообщения, который Вы хотите отправить всем пользователям.'),

                Button::make()
                    ->title('Отправить')
                    ->method('makeSendingJob')

            ])->with(100)

        ];
    }

    public function makeSendingJob(Request $request)
    {
        /*
        Mail::raw($request->get('content'), function (Message $message) use ($request) {

            $message->subject($request->get('subject'));

            foreach ($request->get('users') as $email) {
                $message->to($email);
            }
        });
        */

        ProcessMassSending::dispatch($request->get('content'));
        \alert('Отлично! Рассылка добавлена в очередь на исполнение');
        return back();
    }


}
