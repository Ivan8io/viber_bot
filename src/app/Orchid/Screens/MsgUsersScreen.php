<?php

namespace App\Orchid\Screens;

use App\KeyboardMaker;
use App\MsgUser;
use App\Orchid\Layouts\MsgUserListLayout;
use BotMan\BotMan\Storages\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Layout;
use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use TheArdent\Drivers\Viber\ViberDriver;

class MsgUsersScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Пользователи';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Список пользователей, подписанных на бот';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $users = MsgUser::all();

        return [
            'users' => MsgUser::where('is_found', true)->get(),
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
            Link::name('Выгрузить пользователей')
                ->link('http://bizarro.botgrid.net/usersdownload')
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

            MsgUserListLayout::class,

            Layout::modal('messageModal', [
                Layout::rows([
                    Input::make('message')
                        ->type('test')
                        ->title(__('Введите сообщение'))
                        ->placeholder(__('текст сообщения...')),
                ]),
            ])->title('Отправить сообщение пользователю')

                ->applyButton('Отправить')
                ->closeButton('Отмена'),
        ];
    }

    public function sendMessage(MsgUser $user, Request $request)
    {
        $message = $this->request->get('message');
        $viberId = $user->viber_id;

        $botman = resolve('botman');
        $botman->say($message, $viberId, ViberDriver::class,KeyboardMaker::GetMainViberKeyboard());

        Alert::success('Ваше сообщение успешно отправлено');
        return back();
    }

}
