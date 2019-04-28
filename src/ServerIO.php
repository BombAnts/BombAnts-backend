<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-02
 * Time: 11:36 AM
 */

namespace bombants\backend;


use bombants\backend\commands\AuthenticateCommand;
use bombants\backend\commands\Command;
use bombants\backend\commands\GameCreateCommand;
use bombants\backend\commands\GameJoinCommand;
use bombants\backend\commands\GameListCommand;
use bombants\backend\models\Game;
use bombants\backend\models\Player;
use bombants\backend\models\PlayerAuthenticated;
use bombants\backend\models\PlayerNull;
use bombants\backend\responses\Authenticated;
use bombants\backend\responses\AuthenticatedAlready;
use bombants\backend\responses\AuthenticatedNot;
use bombants\backend\responses\GameCreated;
use bombants\backend\responses\GameCreateInvalid;
use bombants\backend\responses\MessageInvalid;
use bombants\backend\responses\PlayerJoinedGame;
use bombants\backend\responses\PlayerJoinedGameAlready;
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

    private $playerConnections = null;

    public function __construct(Server $server)
    {
        $this->server = $server;
        $this->playerConnections = new \SplObjectStorage();
    }

    function onOpen(ConnectionInterface $conn)
    {
        $this->playerConnections->attach($conn, new PlayerNull());
        echo 'Connection open'.PHP_EOL;
    }

    function onClose(ConnectionInterface $conn)
    {
        /** @var Player $player */
        $player = $this->playerConnections->offsetGet($conn);
        $player->leaveGame();

        $this->playerConnections->detach($conn);
        echo 'Connection closed'.PHP_EOL;
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        var_dump($e->getMessage());
        var_dump(get_class($e));
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

        $token = new TokenNull();
        if (false === empty($msg->token)) {
            $token = TokenValue::fromString($msg->token);
        }

        $player = $this->playerConnections->offsetGet($from);
        // if the authentication token is not correct we have an unauthenticated user
        if ($token instanceof Token && false === $player->isAuthenticated($token)) {
            $player = new PlayerNull();
        }


        $commands = [
            AuthenticateCommand::class,
            GameListCommand::class,
            GameJoinCommand::class,
            GameCreateCommand::class,
        ];

        $response = null;
        foreach($commands as $commandClass) {
            /** @var Command $command */
            $command = new $commandClass($player, $this->games);
            if (!$command->shouldRun($msg)) {
                unset($command);
                continue;
            }

            $response = $command->run($msg);
            $player = $command->getPlayer();
        }

        if ($response !== null) {
            $this->playerConnections->offsetSet($from, $player);
            return $from->send((string)$response);
        }

        echo 'Connection message: '.PHP_EOL;
        var_dump($from->resourceId);
        var_dump($msg);
    }



    private function handleGameCreate(PlayerAuthenticated $player, $msg)
    {
        if (empty($msg->data->name)) {
            $response = new GameCreateInvalid();
            return $response;
        }

        // TODO check if player already in a game?

        $game = new Game($player, $msg->data->name);
        $this->games[] = $game;


        $response = new GameCreated($game);
        return $response;
    }
}
