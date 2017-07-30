<?php

namespace bombants\backend\models;

use bombants\backend\responses\Response;
use bombants\backend\value\Token;
use bombants\backend\value\TokenValue;
use Ratchet\ConnectionInterface;

class PlayerAuthenticated  implements Player
{
    /** @var  ConnectionInterface $connection */
    private $connection;

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
        $this->game !== null;
    }

    public function joinGame(Game $game)
    {
        $this->game = $game;
        $game->addPlayer($this);
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


    public function __construct(ConnectionInterface $connection, string $name)
    {
        $this->connection = $connection;

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

    public function sendResponse(Response $response)
    {
        $this->connection->send((string)$response);
    }

    public function __toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
