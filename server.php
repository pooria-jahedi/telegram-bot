<?php
// includes
include 'functions.php';
// Controllers
use App\Controller\V1\MessageController;
use App\Controller\V1\CallBackController;
use App\Controller\V1\CommandController;

try {

    $bot = new \TelegramBot\Api\Client('1138442768:AAGhIYvxopbKGngB6NiKT_6sH52UoXsl4zU');

    new CommandController($bot);

    $bot->on(function ($update) use ($bot) {

        $callback = $update->getCallbackQuery();
        $message = $update->getMessage();

        if ($message != null) {

            new MessageController($bot,$message);

        } elseif ($callback != null) {

            new CallBackController($bot,$callback);
        }

    }, function ($update) {
        return true;
    });

    $bot->run();

} catch (\TelegramBot\Api\Exception $e) {

    error_log(print_r($e->getMessage(), true));

}