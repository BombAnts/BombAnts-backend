<?php

namespace bombants\backend\value;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class TokenNull extends Token
{
    public function getValue()
    {
        return null;
    }


    public function __construct() {
    }

    public function __toString()
    {
        return "";
    }

    public function equalsToken(Token $token) {
        return false;
    }
}
