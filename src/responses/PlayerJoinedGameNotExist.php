<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-06
 * Time: 07:17 AM
 */

namespace bombants\backend\responses;


class PlayerJoinedGameNotExist implements Response
{
    private $code = 401;
    private $event = 'game.playerJoinedGameNotExist';

    public function __toString()
    {
        $message = json_encode([
            'code' => $this->code,
            'event' => $this->event
        ]);
        return $message;
    }
}
