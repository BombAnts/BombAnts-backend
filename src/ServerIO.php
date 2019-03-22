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
use bombants\backend\responses\PlayerJoinedGame;
use bombants\backend\responses\PlayerJoinedGameInvalid;
use bombants\backend\responses\PlayerJoinedGameNotExist;
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
            return $from->send((string)new MessageInvalid());
        }

        if (empty($msg->path)) {
            return $from->send((string)new MessageInvalid());
        }

        $player = $this->server->getPlayer($playerId);

        $token = !empty($msg->token) ?
                            TokenValue::fromString($msg->token) :
                            new TokenNull();

        if ($msg->path === '/login') {
            $response = $this->handleLogin($player, $token, $from, $msg);
            return $from->send((string)$response);
        }

        if (empty($msg->id)) {
            return $from->send((string)new MessageInvalid());
        }

        if (!$player->isAuthenticated($token)) {
            $response = new AuthenticatedNot();
            return $from->send((string)$response);
        }

        if ($msg->path === '/games') {
            $response = $this->handleGameList();
            return $from->send(json_encode($response));
        }

        if ($msg->path === '/games/join') {
            $response = $this->handleGameJoin($player, $msg);
            return $from->send((string)$response);
        }

        if ($msg->path === '/games/create') {
            $response = $this->handleGameCreate($player, $msg);
            return $from->send((string)$response);
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

        if (false === is_object($msg->data)) {
            return $from->send((string)new MessageInvalid());
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

    private function handleGameJoin(PlayerAuthenticated $player, $msg)
    {
        if (empty($msg->data->id)) {
            $response = new PlayerJoinedGameInvalid();
            return $response;
        }

        $gameId = $msg->data->id;


        $game = null; // TODO null object?
        foreach ($this->games as $gameToJoin) {
            if ((string)$gameToJoin->getId() !== $gameId) {
                continue;
            }

            $game = $gameToJoin;
            break;
        }

        if (!$game instanceof Game) {
            return PlayerJoinedGameNotExist();
        }

        $gamePlayer = $player->joinGame($game);

        return new PlayerJoinedGame($game, $gamePlayer);
    }

    private function handleGameCreate(PlayerAuthenticated $player, $msg)
    {
        if (empty($msg->data->name)) {
            $response = new GameCreateInvalid();
            return $response;
        }

        $game = new Game($player, $msg->data->name);
        $this->games[] = $game;


        $response = new GameCreated($game);
        return $response;
    }
}
