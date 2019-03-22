<?php

namespace bombants\backend\responses;

class PlayerJoinedGameAlready implements Response
{
    private $code = 406;
    private $event = 'game.playerJoinedGameAlready';


    public function __toString()
    {
        $message = json_encode([
            'code' => $this->code,
            'event' => $this->event
        ]);
        return $message;
    }
}
