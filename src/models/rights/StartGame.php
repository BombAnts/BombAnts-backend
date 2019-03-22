<?php
namespace bombants\backend\models\rights;

use JsonSerializable;

class StartGame implements RightsInterface, JsonSerializable
{
    const NAME = 'StartGame';

    public function getName(): string
    {
        return self::NAME;
    }

    public function jsonSerialize()
    {
        return [
            'name' => self::NAME
        ];
    }
}
