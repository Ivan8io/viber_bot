<?php

namespace App\Jobs;

use App\KeyboardMaker;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use TheArdent\Drivers\Viber\ViberDriver;

class ProcessPromoMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $viberId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($vid)
    {
        //
        $this->viberId = $vid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $botman = resolve('botman');
        //
        sleep(3);

        $last_message = "Вот наши соц. сети, подпишитесь и будьте в курсе всех новинок и акций.
                        \nhttps://www.instagram.com/bizzarro_outlet_krsk
                        \nhttps://vk.com/bizzarro.outlet24
                        \nА еще, мои друзья получают рассылку раньше остальных.";

        $botman->say($last_message, $this->viberId, ViberDriver::class,KeyboardMaker::GetMainViberKeyboard());
    }
}
