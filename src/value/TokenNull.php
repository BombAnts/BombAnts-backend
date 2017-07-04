<?php

namespace bombants\backend\value;

class TokenNull implements Token
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
