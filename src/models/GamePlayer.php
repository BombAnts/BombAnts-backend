<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-06
 * Time: 20:51 PM
 */

namespace bombants\backend\models;

use bombants\backend\models\rights\Collection;
use bombants\backend\models\rights\RightsInterface;

/**
 * Used to represent a player in 1 game
 *
 * Class GamePlayer
 * @package bombants\backend\models
 */
class GamePlayer implements \JsonSerializable
{
    private $player;
    private $location;

    /**
     * @var Collection
     */
    private $rights;

    public function __construct(PlayerAuthenticated $player)
    {
        $this->player = $player;
        $this->rights = new Collection();
    }

    /**
     * @return PlayerAuthenticated
     */
    public function getPlayer()
    {
        return $this->player;
    }

    public function setSpawnPoint(Location $location)
    {
        $this->location = $location;
    }


    public function hasRight(RightsInterface $right): bool
    {
        return $this->rights[$right->getName()] instanceof RightsInterface;
    }

    public function addRight(RightsInterface $right)
    {
        $this->rights->add($right);
    }

    public function __toArray()
    {
        return [
            'player' => $this->player->__toArray(),
            'rights' => $this->rights,
        ];
    }

    public function jsonSerialize()
    {
        return $this->__toArray();
    }
}
