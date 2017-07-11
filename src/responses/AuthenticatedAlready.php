<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-03
 * Time: 20:03 PM
 */

namespace bombants\backend\responses;


class AuthenticatedAlready
{
    private $code = 422;
    private $event = 'user.alreadyAuthenticated';
    private $hint = 'Call logout first: {"path" : "/logout", "data" : {}}';

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
