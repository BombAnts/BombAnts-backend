<?php

namespace bombants\backend\models;

use bombants\backend\responses\Response;
use bombants\backend\value\TokenValue;
use Ratchet\ConnectionInterface;

class Player
{
    /** @var  ConnectionInterface $connection */
    private $connection;

    /** @var  int $id */
    private $id = null;

    /** @var  TokenValue $token */
    private $token = null;

    /** @var Game $game */
    private $game = null;

    /**
     * @param TokenValue $token
     */
    public function setToken(TokenValue $token)
    {
        $this->token = $token;
    }

    public function isInGame()
    {
        $this->game !== null;
    }

    public function joinGame(Game $game)
    {
        $this->game = $game;
        $game->addPlayer($this);
    }

    public function removeFromGame()
    {
        if (!$this->game instanceof Game) {
            return true;
        }

        $this->game->removePlayer($this);
        $this->game = null;
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

    public function __construct(ConnectionInterface $connection, int $id)
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

    public function sendResponse(Response $response)
    {
        $this->connection->send((string)$response);
    }
}
