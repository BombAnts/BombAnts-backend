<?php

namespace bombants\backend\commands;

use bombants\backend\models\Game;
use bombants\backend\models\Player;
use bombants\backend\models\PlayerAuthenticated;
use bombants\backend\responses\AuthenticatedNot;
use bombants\backend\responses\GameList;
use bombants\backend\responses\MessageInvalid;

class GameListCommand implements Command
{
    /**
     * @var Player
     */
    private $player;
    /**
     * @var Game[]
     */
    private $games;

    public function __construct(Player $player,array $games)
    {
        $this->player = $player;
        $this->games = $games;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function shouldRun(\stdClass $message)
    {
        return $message->path === '/games';
    }

    public function run(\stdClass $message)
    {
        if (false === $this->player instanceof PlayerAuthenticated) {
            return new AuthenticatedNot();
        }


        return new GameList($this->games);
    }
}
