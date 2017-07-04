<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-02
 * Time: 12:24 PM
 */

namespace bombants\backend\responses;


class MessageInvalid implements Response
{
    private $code = 400;
    private $event = 'message.invalid';
    private $hint = 'Send JSON in this format: {"path" : "/path", "data" : {}}';

    public function __toString()
    {
        $message = json_encode([
            'code' => $this->code,
            'event' => $this->event,
            'hint' => $this->hint
        ]);
        $message = stripslashes($message);
        return $message;
    }

}
