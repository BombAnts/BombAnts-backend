<?php

namespace bombants\backend;

use bombants\backend\models\Player;
use bombants\backend\models\PlayerAuthenticated;
use bombants\backend\models\PlayerNull;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require '../vendor/autoload.php';

class ServerExample
{
    /** @var  IoServer $server */
    private $server = null;


    public function __construct()
    {
        $ws = new WsServer(new ServerIO());
        $ws->disableVersion(0); // old, bad, protocol version

        // Make sure you're running this as root
        $this->server = IoServer::factory(new HttpServer($ws));
    }

    public function start()
    {
        $this->server->run();
    }
}


$server = new ServerExample();
$server->start();
