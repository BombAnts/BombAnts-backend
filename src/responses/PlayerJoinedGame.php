<?php

namespace bombants\backend\responses;

use bombants\backend\models\Game;
use bombants\backend\models\GamePlayer;

class PlayerJoinedGame implements Response
{
    private $code = 200;
    private $event = 'game.playerJoinedGame';

    private $game;
    private $player;

    public function __construct(Game $game, GamePlayer $player)
    {
        $this->game = $game;
        $this->player = $player;

    }

    public function __toString()
    {
        $message = json_encode([
            'code' => $this->code,
            'event' => $this->event,
            'game' => $this->game->__toArray(),
            'player' => $this->player->__toArray(),
        ]);
        return $message;
    }
}
