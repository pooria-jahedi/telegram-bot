<?php

namespace App\Controller\V1;

use App\Controller\V1\Controller;
use App\Traits\Language;
// models
use App\Models\Users;

class CommandController extends Controller
{
    use Language;

    public $bot;

    public function __construct($bot)
    {
        $this->bot = $bot;
        $this->start();
    }

    function start()
    {
        $this->bot->command('start', function ($message) {
            $user = Users::firstOrCreate(['user_telegram_id' => $message->getFrom()->getId()]);
            if (in_array($message->getChat()->getId(), $this->management())) { // if user is admin
                $keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup([
                    [
                        ['text' => self::translate('error.500')]
                    ]
                ], false, true);
                $this->bot->sendMessage($message->getChat()->getId(), $this->translate('error.500'), null, false, null, $keyboard);
            }
        }); // end of command
    }

}