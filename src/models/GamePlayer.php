<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-06
 * Time: 20:51 PM
 */

namespace bombants\backend\models;

/**
 * Used to represent a player in 1 game
 *
 * Class GamePlayer
 * @package bombants\backend\models
 */
class GamePlayer
{
    private $player;

    // player bonusses
    private $flame = 1;
    private $fullFlame = false;

    private $numberOfBombs = 1;
    private $speed = 1;


    private $location;

    public function setSpawnPoint(Location $location)
    {
        $this->location = $location;
    }

    public function __construct(Player $player)
    {
        $this->player;
    }

    public function pickedUpFlame()
    {
        $this->flame += 1;
    }

    public function pickedUpFullFlame()
    {
        $this->fullFlame = true;
    }

    public function pickedUpExtraBomb()
    {
        $this->numberOfBombs += 1;
    }

    public function pickedUpSpeed()
    {
        $this->speed += 1;
    }


}
