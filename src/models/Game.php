<?php

namespace bombants\backend\models;

use bombants\backend\value\TokenValue;

class Game
{
    // config
    private $maxPlayers = 8;

    /** @var  Player[] $players */
    private $players;

    /** @var  TokenValue $id */
    private $id;

    private $name;

    /**
     * @return TokenValue
     */
    public function getId(): TokenValue
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getMaxPlayers(): int
    {
        return $this->maxPlayers;
    }

    public function getAmountOfPlayers()
    {
        return count($this->players);
    }

    public function __construct(string $name)
    {
        $this->id = TokenValue::random();
        $this->name = $name;
    }

    public function addPlayer(Player $player)
    {

    }

    public function removePlayer(Player $player)
    {

    }
}
