<?php

namespace bombants\backend\commands;

use bombants\backend\models\Player;
use bombants\backend\models\PlayerAuthenticated;
use bombants\backend\responses\Authenticated;
use bombants\backend\responses\AuthenticatedAlready;
use bombants\backend\responses\MessageInvalid;

class AuthenticateCommand implements Command
{
    /**
     * @var Player
     */
    private $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function shouldRun(\stdClass $message)
    {
        return $message->path === '/login';
    }

    public function run(\stdClass $message)
    {

        if ($this->player instanceof PlayerAuthenticated) {
            return new AuthenticatedAlready();
        }

        if (
            false === property_exists($message, 'data')
            || false === is_object($message->data)
        ) {
            return new MessageInvalid();
        }

        $this->player = new PlayerAuthenticated($message->data->name);
        return new Authenticated($this->player);
    }
}
