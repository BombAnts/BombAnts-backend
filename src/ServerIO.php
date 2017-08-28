<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-02
 * Time: 11:36 AM
 */

namespace bombants\backend;


use bombants\backend\models\Game;
use bombants\backend\models\Player;
use bombants\backend\models\PlayerAuthenticated;
use bombants\backend\responses\Authenticated;
use bombants\backend\responses\AuthenticatedAlready;
use bombants\backend\responses\AuthenticatedNot;
use bombants\backend\responses\GameCreated;
use bombants\backend\responses\GameCreateInvalid;
use bombants\backend\responses\MessageInvalid;
use bombants\backend\value\Token;
use bombants\backend\value\TokenNull;
use bombants\backend\value\TokenValue;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class ServerIO implements MessageComponentInterface
{

    private $server = null;

    /** @var Game[] $games */
    private $games = [];

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    function onOpen(ConnectionInterface $conn)
    {
        echo 'Connection opened'.PHP_EOL;
    }

    function onClose(ConnectionInterface $conn)
    {
        echo 'Connection closed'.PHP_EOL;
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo 'Connection error'.PHP_EOL;
    }

    function onMessage(ConnectionInterface $from, $msg)
    {
        $msg = json_decode($msg);
        $playerId = !empty($msg->id) ? $msg->id : null;

        // if the message can not be decoded
        if (false === is_object($msg)) {
            $from->send((string)new MessageInvalid());
            return;
        }

        if (empty($msg->path)) {
            $from->send((string)new MessageInvalid());
            return;
        }

        $player = $this->server->getPlayer($playerId);

        $token = !empty($msg->token) ?
                            TokenValue::fromString($msg->token) :
                            new TokenNull();

        if ($msg->path === '/login') {
            $response = $this->handleLogin($player, $token, $from, $msg);
            $from->send((string)$response);
            return;
        }

        if (empty($msg->id)) {
            $from->send((string)new MessageInvalid());
            return;
        }

        if (!$player->isAuthenticated($token)) {
            $response = new AuthenticatedNot();
            $from->send((string)$response);
            return;
        }

        if ($msg->path === '/games') {
            $response = $this->handleGameList();
            $from->send(json_encode($response));
            return;
        }

        if ($msg->path === '/games/create') {
            $response = $this->handleGameCreate($player, $msg);
            $from->send((string)$response);
            return;
        }

        echo 'Connection message: '.PHP_EOL;
        var_dump($from->resourceId);
        var_dump($msg);
    }

    private function handleLogin(Player $player, Token $token, ConnectionInterface $from, $msg)
    {
        if ($player->isAuthenticated($token)) {
            return new AuthenticatedAlready();
        }

        $player = new PlayerAuthenticated($from, $msg->data->name);
        $this->server->addPlayer($player);

        return new Authenticated($player);
    }

    private function handleGameList()
    {
        $result = [
            'event' => 'game.list',
            'data' => []
        ];
        foreach($this->games as $game) {
            $result['data'][] = [
                'id' => (string)$game->getId(),
                'name' => $game->getName(),
                'amountPlayers' => $game->getAmountOfPlayers(),
                'maxPlayers' => $game->getMaxPlayers(),
            ];
        }
        return $result;
    }

    private function handleGameCreate(PlayerAuthenticated $player, $msg)
    {
        if (empty($msg->data->name)) {
            $response = new GameCreateInvalid();
            return $response;
        }

        $game = new Game($player, $msg->data->name);
        $this->games[] = $game;
        $player->joinGame($game);

        $response = new GameCreated($game);
        return $response;
    }
}
