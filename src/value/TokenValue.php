<?php

namespace bombants\backend\value;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class TokenValue implements Token
{
    private $value;

    public static function random()
    {
        $uuid = Uuid::uuid4();
        return new static($uuid);
    }

    public static function fromString(string $value)
    {
        try {
            $uuid = Uuid::fromString($value);
            return new static($uuid);

        // if the uuid is invalid
        } catch (InvalidUuidStringException $e) {
            return new TokenNull();
        }
    }

    private function __construct(UuidInterface $value) {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value->toString();
    }

    public function __toString()
    {
        return $this->getValue();
    }

    public function equalsToken(Token $token) {
        return $this->getValue() === $token->getValue();
    }
}
