<?php

namespace App\Controller\V1;

use App\Controller\V1\Controller;
use App\Traits\Language;

// models
use App\Models\Users;

class CallBackController extends Controller
{

    use Language;
    
    public $bot;
    public $callback;
    public $user;
    public $user_tg_id;
    public $callback_data;


    public function __construct($bot,$callback)
    {
        $this->bot = $bot;
        $this->callback = $callback;
        $this->callback_data = $callback->getData();
        $this->user_tg_id = $callback->getFrom()->getId();
        //$user = Users::where('user_telegram_id', $this->user_tg_id)->first();
        $this->user = $user ?? null;
    }

}