<?php

namespace bombants\backend;

use bombants\backend\models\Player;
use bombants\backend\models\PlayerAuthenticated;
use bombants\backend\models\PlayerNull;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require '../vendor/autoload.php';

class Server
{
    /** @var  IoServer $server */
    private $server = null;

    private $games;

    private $players = [];

    public function __construct()
    {
        $ws = new WsServer(new ServerIO($this));
        $ws->disableVersion(0); // old, bad, protocol version

        // Make sure you're running this as root
        $this->server = IoServer::factory(new HttpServer($ws));
    }

    public function start()
    {
        $this->server->run();
    }

    public function addPlayer(PlayerAuthenticated $player)
    {
        $this->players[$player->getId()] = $player;
    }

    public function getPlayer($id = null) : Player
    {
        if ($id === null || !array_key_exists($id, $this->players)) {
            return new PlayerNull();
        }

        return $this->players[$id];
    }

    public function getPlayerCount()
    {
        return count($this->players);
    }
}


$server = new Server();
$server->start();
