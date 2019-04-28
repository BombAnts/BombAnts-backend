<?php

namespace bombants\backend\commands;

use bombants\backend\models\Game;
use bombants\backend\models\Player;
use bombants\backend\models\PlayerAuthenticated;
use bombants\backend\responses\AuthenticatedNot;
use bombants\backend\responses\MessageInvalid;
use bombants\backend\responses\PlayerJoinedGame;
use bombants\backend\responses\PlayerJoinedGameAlready;
use bombants\backend\responses\PlayerJoinedGameInvalid;
use bombants\backend\responses\PlayerJoinedGameNotExist;

class GameJoinCommand implements Command
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
        return $message->path === '/games/join';
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


        if (empty($message->gameId)) {
            return new PlayerJoinedGameInvalid();
        }

        $gameId = $message->gameId;


        $game = null; // TODO null object?
        foreach ($this->games as $gameToJoin) {
            if ((string)$gameToJoin->getId() !== $gameId) {
                continue;
            }

            $game = $gameToJoin;
            break;
        }

        if (!$game instanceof Game) {
            return new PlayerJoinedGameNotExist();
        }

        if ($game->isPlayerPartOf($this->player)) {
            return new PlayerJoinedGameAlready();
        }

        $gamePlayer = $this->player->joinGame($game);

        return new PlayerJoinedGame($game, $gamePlayer);
    }
}
