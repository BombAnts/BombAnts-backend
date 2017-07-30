<?php

namespace bombants\backend\models;

use bombants\backend\responses\Response;
use bombants\backend\value\Token;
use bombants\backend\value\TokenValue;

class PlayerNull implements Player
{
    public function isInGame() : bool
    {
        return false;
    }

    public function joinGame(Game $game)
    {
    }

    public function leaveGame()
    {
        // TODO: Implement leaveGame() method.
    }


    public function getId(): string
    {
        return $this->id->__toString();
    }


    public function getToken(): TokenValue
    {
        return $this->token;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function __construct()
    {
        $this->id = TokenValue::random();
    }

    public function isAuthenticated(Token $token) : bool
    {
        return false;
    }

    public function sendResponse(Response $response)
    {

    }

    public function __toArray() : array
    {
        return [];
    }
}
