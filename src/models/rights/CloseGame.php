<?php
namespace bombants\backend\models\rights;

use JsonSerializable;

class CloseGame implements RightsInterface, JsonSerializable
{
    const NAME = 'CloseGame';

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
