<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-06
 * Time: 07:17 AM
 */

namespace bombants\backend\responses;


class PlayerJoinedGameInvalid implements Response
{
    private $code = 401;
    private $event = 'game.playerJoinedInvalid';
    private $hint = 'Send JSON in this format: {"path" : "/game/join", "data" : { "id" => "game id"}}';

    public function __toString()
    {
        $message = json_encode([
            'code' => $this->code,
            'event' => $this->event,
            'hint' => $this->hint
        ]);
        return $message;
    }
}
