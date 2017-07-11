<?php

namespace bombants\backend\responses;

class AuthenticatedNot implements Response
{
    private $code = 401;
    private $event = 'user.notAuthenticated';
    private $hint = 'Send JSON in this format: {"path" : "/login", "data" : {}} In the response you find a token, add this as token:theToken
    ';

    public function __toString()
    {
        $message = json_encode([
            'code' => $this->code,
            'event' => $this->event,
            'hint' => $this->hint
        ]);
        return $message;
    }

}
