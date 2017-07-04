<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-04
 * Time: 20:21 PM
 */

namespace bombants\backend\value;


interface Token
{
    public function getValue();

    public function equalsToken(Token $token);
}
