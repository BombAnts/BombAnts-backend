<?php

namespace bombants\backend\models;

use bombants\backend\models\rights\CloseGame;
use bombants\backend\models\rights\StartGame;
use bombants\backend\value\TokenValue;

class Game implements \JsonSerializable
{
    // config
    private $maxPlayers = 8;

    /** @var  TokenValue $id */
    private $id;

    /** @var string $name */
    private $name;

    /** @var  GameBoard $board */
    private $board;

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

    public function __construct(PlayerAuthenticated $player, string $name)
    {
        $this->id = TokenValue::random();
        $this->addGameCreator($player);
        $this->name = $name;
        $this->board = new GameBoardBasic();
    }

    public function addGameCreator(PlayerAuthenticated $player) : GamePlayer
    {
        $gamePlayer = $this->addPlayer($player);
        $gamePlayer->addRight(new StartGame());
        $gamePlayer->addRight(new CloseGame());
        return $gamePlayer;
    }


    public function addPlayer(PlayerAuthenticated $player) : GamePlayer
    {
        // TODO what is the player is already in a game ?
        $gamePlayer = new GamePlayer($player);
        $this->players[] = $gamePlayer;
        return $gamePlayer;
    }

    public function removePlayer(PlayerAuthenticated $player)
    {

    }

    public function start()
    {
        // TODO set random start positions
        // Start the game
    }

    public function __toArray()
    {
        return [
            'id' => (string)$this->getId(),
            'name' => $this->getName(),
            'players' => $this->players,
        ];
    }

    public function jsonSerialize()
    {
        return $this->__toArray();
    }
}
