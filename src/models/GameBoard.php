<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-06
 * Time: 21:10 PM
 */

namespace bombants\backend\models;


interface GameBoard
{
    public function getName() : string ;

    public function isCellWalkable($x, $y) : bool;
}
