<?php

namespace App\Controller\V1;

use App\Controller\V1\Controller;
use App\Traits\Language;
use App\Models\Users;

class MessageController extends Controller
{

    use Language;

    public $bot;
    public $message;
    public $user;
    public $user_tg_id;
    public $text;

    public function __construct($bot, $message)
    {
        $this->bot = $bot;
        $this->message = $message;
        $this->user_tg_id = $message->getChat()->getId();
        $this->text = $message->getText();
        //$user = Users::where('user_telegram_id', $this->user_tg_id)->first();
        $this->user = $user ?? null;
    }

}