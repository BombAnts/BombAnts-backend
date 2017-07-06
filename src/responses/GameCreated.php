<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-06
 * Time: 07:17 AM
 */

namespace bombants\backend\responses;


use bombants\backend\models\Game;

class GameCreated implements Response
{
    private $code = 200;
    private $event = 'game.created';

    private $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function __toString()
    {
        $message = json_encode([
            'code' => $this->code,
            'event' => $this->event,
            'game' => [
                'name' => $this->game->getName(),
                'id' => (string)$this->game->getId(),
            ]
        ]);
        $message = stripslashes($message);
        return $message;
    }
}
