<?php

namespace bombants\backend\models;

use bombants\backend\value\Token;
use bombants\backend\value\TokenValue;

class PlayerAuthenticated  implements Player
{
    /** @var  int $id */
    private $id = null;

    /** @var string $name */
    private $name = 'PlayerAuthenticated';

    /** @var  TokenValue $token */
    private $token = null;

    /** @var Game $game */
    private $game = null;

    /**
     * @param string $name
     * @deprecated
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param TokenValue $token
     * @deprecated
     */
    public function setToken(TokenValue $token)
    {
        $this->token = $token;
    }

    public function isInGame() : bool
    {
        return $this->game !== null;
    }

    public function joinGame(Game $game) : GamePlayer
    {
        $this->game = $game;
        return $game->addPlayer($this);
    }

    public function leaveGame()
    {
        if (!$this->game instanceof Game) {
            return true;
        }

        $this->game->removePlayer($this);
        $this->game = null;
    }

    public function getId(): string
    {
        return $this->id->__toString();
    }

    /**
     * @return TokenValue
     */
    public function getToken(): TokenValue
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    public function __construct(string $name)
    {
        $this->id = TokenValue::random();
        $this->token = TokenValue::random();
        $this->name = $name;
    }

    public function isAuthenticated(Token $token)
    {
        if (!$this->token instanceof TokenValue) {
            return false;
        }
        return $this->token->equalsToken($token);
    }

    public function __toArray()
    {
        return [
            'id' => (string)$this->id,
            'name' => $this->name,
        ];
    }
}
