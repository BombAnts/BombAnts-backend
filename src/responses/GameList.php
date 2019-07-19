<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-06
 * Time: 07:17 AM
 */

namespace bombants\backend\responses;


use bombants\backend\models\Game;

class GameList implements Response
{
    private $code = 200;
    private $event = 'game.list';

    /**
     * @var array game
     */
    private $games;

    public function __construct(array $games)
    {
        $this->games = $games;
    }

    public function __toString()
    {
        $mapGame = function (Game $game) {
            return $game->__toArray();
        };

        $message = json_encode([
            'code' => $this->code,
            'event' => $this->event,
            'games' => array_map($mapGame, $this->games),
        ]);
        return $message;
    }
}
