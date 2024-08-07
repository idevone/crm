<?php

namespace app\components;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use TelegramBot\CrashPad;
use TelegramBot\Request;
use TelegramBot\Telegram;

class TelegramBot
{
    private $botId;
    private $lastUpdateId = 0;

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