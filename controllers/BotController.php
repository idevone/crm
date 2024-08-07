<?php

namespace app\controllers;

use TelegramBot\CrashPad;
use TelegramBot\Request;
use TelegramBot\Telegram;
use Yii;
use yii\web\Controller;

class BotController extends Controller
{
    public function __construct($botId)
    {
        $this->botId = $botId;
    }

    public function start()
    {
        $admin_id = 792280460;

        Telegram::setToken($this->botId);
        CrashPad::setDebugMode($admin_id);

        $result = Request::sendMessage([
            'chat_id' => $admin_id,
            'text' => 'text',
        ]);
    }
}