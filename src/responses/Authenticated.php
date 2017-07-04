<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-03
 * Time: 20:03 PM
 */

namespace bombants\backend\responses;


use bombants\backend\models\Player;

class Authenticated
{
    private $code = 200;
    private $event = 'user.authenticated';

    private $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function __toString()
    {
        $message = json_encode([
            'code' => $this->code,
            'event' => $this->event,
            'token' => (string)$this->player->getToken(),
        ]);
        $message = stripslashes($message);
        return $message;
    }
}
