<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-06
 * Time: 07:17 AM
 */

namespace bombants\backend\responses;


class GameCreateInvalid implements Response
{
    private $code = 401;
    private $event = 'game.createInvalid';
    private $hint = 'Send JSON in this format: {"path" : "/game/create", "data" : { "name" => "game name"}}';

    public function __toString()
    {
        $message = json_encode([
            'code' => $this->code,
            'event' => $this->event,
            'hint' => $this->hint
        ]);
        $message = stripslashes($message);
        return $message;
    }
}
