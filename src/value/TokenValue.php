<?php

namespace bombants\backend\value;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class TokenValue implements Token
{
    private $value;

    public function getValue()
    {
        return $this->value->toString();
    }

    public static function random()
    {
        $uuid = Uuid::uuid4();
        return new static($uuid);
    }

    public static function fromString(string $value)
    {
        $uuid = Uuid::fromString($value);
        return new static($uuid);
    }

    private function __construct(UuidInterface $value) {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->getValue();
    }

    public function equalsToken(Token $token) {
        return $this->getValue() === $token->getValue();
    }
}
