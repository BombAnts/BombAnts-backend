<?php

use bombants\backend\responses\MessageInvalid;

class ServerIOTest extends \PHPUnit\Framework\TestCase {

    public function test_when_an_invalid_message_is_received_send_MessageInvalid_response()
    {
        $connection = $this->createMock(\Ratchet\ConnectionInterface::class);
        $connection->expects($this->once())->method('send')->with((string)new MessageInvalid());

        $serverIO = new \bombants\backend\ServerIO();
        $serverIO->onOpen($connection);

        $serverIO->onMessage($connection, 'hallo');
    }

    public function test_when_an_invalid_json_is_received_send_MessageInvalid_response()
    {
        $connection = $this->createMock(\Ratchet\ConnectionInterface::class);
        $connection->expects($this->once())->method('send')->with((string)new MessageInvalid());

        $serverIO = new \bombants\backend\ServerIO();
        $serverIO->onOpen($connection);

        $serverIO->onMessage($connection, json_encode(['hallo']));
    }

    public function test_that_we_can_succesfully_authenticate()
    {
        $connection = $this->createMock(\Ratchet\ConnectionInterface::class);
        $connection->expects($this->once())->method('send')->with((string)new MessageInvalid());

        $serverIO = new \bombants\backend\ServerIO();
        $serverIO->onOpen($connection);

        $serverIO->onMessage($connection, json_encode([
            'path' => '/login',
            'data' => ['name' => 'mathijs']
        ]));
    }
}