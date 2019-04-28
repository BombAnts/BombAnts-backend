<?php

namespace bombants\backend\commands;

use bombants\backend\models\Player;

interface Command
{
    public function getPlayer(): Player;

    public function shouldRun(\stdClass $message);

    public function run(\stdClass $message);
}
