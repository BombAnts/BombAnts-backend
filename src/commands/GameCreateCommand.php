<?php

namespace bombants\backend\commands;

use bombants\backend\models\Game;
use bombants\backend\models\Player;
use bombants\backend\models\PlayerAuthenticated;
use bombants\backend\responses\AuthenticatedNot;
use bombants\backend\responses\GameCreated;
use bombants\backend\responses\GameCreateInvalid;
use bombants\backend\responses\MessageInvalid;
use bombants\backend\responses\PlayerJoinedGameAlready;

class GameCreateCommand implements Command
{
    /**
     * @var Player
     */
    private $player;

    /**
     * @var Game
     */
    private $game;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getGame(): Game
    {
        return $this->game;
    }

    public function shouldRun(\stdClass $message)
    {
        return $message->path === '/games/create';
    }

    public function run(\stdClass $message)
    {
        if (false === $this->player instanceof PlayerAuthenticated) {
            return new AuthenticatedNot();
        }

        if ($this->player->isInGame()) {
            return new PlayerJoinedGameAlready();
        }

        if (false === is_object($message->data)) {
            return new MessageInvalid();
        }

        if (empty($message->id)) {
            return new MessageInvalid();
        }

        if (empty($message->data->name)) {
            return new GameCreateInvalid();
        }

        $game = new Game($this->player, $message->data->name);
        $this->game = $game;

        return new GameCreated($game);
    }
}
