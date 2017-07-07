<?php

namespace bombants\backend\models;

use bombants\backend\value\TokenValue;

class Game
{
    // config
    private $maxPlayers = 8;

    /** @var  TokenValue $id */
    private $id;

    /** @var string $name */
    private $name;

    /** @var  GameBoard $board */
    private $board;

    /** @var  Player $master */
    private $master;

    /** @var  GamePlayer[] $players */
    private $players;

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

    public function __construct(Player $player, string $name)
    {
        $this->id = TokenValue::random();
        $this->master = $player;
        $this->name = $name;
        $this->board = new GameBoardBasic();
    }

    public function addPlayer(Player $player)
    {
        $this->players[] = new GamePlayer($player);
    }

    public function removePlayer(Player $player)
    {

    }

    public function start()
    {
        // TODO set random start positions
        // Start the game
    }
}
