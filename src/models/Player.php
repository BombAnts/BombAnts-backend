<?php

namespace bombants\backend\models;

use bombants\backend\value\Token;

class Player
{
    /** @var  int $id */
    private $id = null;

    /** @var  Token $token */
    private $token = null;

    /**
     * @param Token $token
     */
    public function setToken(Token $token)
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
     * @return Token
     */
    public function getToken(): Token
    {
        return $this->token;
    }

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function isAuthenticated(Token $token)
    {
        if (!$this->token instanceof Token) {
            return false;
        }
        return $this->token->equalsToken($token);
    }

}
