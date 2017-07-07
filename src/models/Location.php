<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2017-07-07
 * Time: 12:02 PM
 */

namespace bombants\backend\models;


class Location
{
    const SUB_CELLS_X = 3;
    CONST SUB_CELLS_Y = 3;

    private $x = 1;
    private $y = 1;

    private $cellX = 2;
    private $celly = 2;

    public function __construct(GameBoard $gameBoard, $x, $y)
    {
    }

    // TODO for now we assume we can walk on every cell
    public function moveLeft()
    {
        // move to the next cell left of this
        if (!$this->canMoveLeft()) {
            return false;
        }

        if ($this->cellX === 1) {
            $this->x -= 1;
            $this->cellX = self::SUB_CELLS_X;
            return true;
        }

        $this->cellX -= 1;
        return true;
    }

    private function canMoveLeft()
    {
        // if we are standing on a cell that is not all to the left we can
        if ($this->x > 1) {
            // todo check if we can actually walk left
            return true;
        }

        // if we are already standing in cell but not on the border we can
        if ($this->cellX > 1) {
            return true;
        }

        return false;
    }

    public function moveRight()
    {

    }

    public function canMoveRIght()
    {
        // if we are standing on a cell that is not all to the left we can
        if ($this->x <= 15) {
            // todo check if we can actually move right
            return true;
        }

        // if we are already standing in cell but not on the border we can
        if ($this->cellX < self::SUB_CELLS_X) {
            return true;
        }

        return false;
    }

    public function moveUp()
    {

    }

    public function moveDown()
    {

    }
}
