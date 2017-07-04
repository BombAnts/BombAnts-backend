<?php

namespace bombants\backend\models;

use bombants\backend\value\TokenValue;

class Player
{
    /** @var  int $id */
    private $id = null;

    /** @var  TokenValue $token */
    private $token = null;

    /**
     * @param TokenValue $token
     */
    public function setToken(TokenValue $token)
    {
        $this->token = $token;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return TokenValue
     */
    public function getToken(): TokenValue
    {
        return $this->token;
    }

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function isAuthenticated(TokenValue $token)
    {
        if (!$this->token instanceof TokenValue) {
            return false;
        }
        return $this->token->equalsToken($token);
    }

}
