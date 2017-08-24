<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-06
 * Time: 21:10 PM
 */

namespace bombants\backend\models;


class GameBoardBasic implements GameBoard
{
    const MAX_X = 15;   // number of cells left to right
    const MAX_Y = 11;   // number of cells up to down

    private $maxPlayers = 8;

    private $spawnLocations = [];

    // TODO 1 = simple grass field for now
    private $board = [
        [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
        [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
        [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
        [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
        [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
        [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
        [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
        [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
        [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
        [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
        [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
    ];

    public function __construct()
    {
        // generate random spawn locations
        for ($i = 1; $i <= $this->maxPlayers; $i++) {
            $x = rand(1,self::MAX_X);
            $y = rand(1,self::MAX_Y);
            $location = new Location($this, $x, $y);
            $this->spawnLocations[$i] = $location;
        }
    }

    public function getName(): string
    {
        return 'Basic';
    }

    public function isCellWalkable($x, $y): bool
    {
        // TODO
        return true;
    }


}
