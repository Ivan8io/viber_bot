<?php

namespace App\Jobs;

use App\KeyboardMaker;
use App\MsgUser;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use TheArdent\Drivers\Viber\ViberDriver;

class ProcessMassSending implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($msg)
    {
        //
        $this->message = $msg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $msg_users = MsgUser::where('is_found', true)->get();

        $botman = resolve('botman');

        foreach ($msg_users as $user)
        {
            $botman->say($this->message, $user->viber_id , ViberDriver::class, KeyboardMaker::GetMainViberKeyboard());
        }
    }
}
