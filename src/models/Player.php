<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-30
 * Time: 21:01 PM
 */

namespace bombants\backend\models;


use bombants\backend\responses\Response;
use bombants\backend\value\Token;
use bombants\backend\value\TokenValue;

interface Player
{
    public function getId(): string;

    public function getToken(): TokenValue;

    public function getName(): string;

    public function isInGame() : bool;

    public function joinGame(Game $game);

    public function leaveGame();

    public function isAuthenticated(Token $token);

    public function sendResponse(Response $response);
}
