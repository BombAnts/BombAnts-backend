<?php

namespace bombants\backend;

use bombants\backend\models\Player;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require '../vendor/autoload.php';

class Server
{
    /** @var  IoServer $server */
    private $server = null;

    private $games;

    private $players;

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

    public function addPlayer(Player $player)
    {
        $this->players[$player->getId()] = $player;
    }

    public function getPlayer($id) : Player
    {
        return $this->players[$id];
    }

    public function getPlayerCount()
    {
        return count($this->players);
    }
}


$server = new Server();
$server->start();
