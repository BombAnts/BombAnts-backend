<?php
/**
 * Created by PhpStorm.
 * User: Mathijs
 * Date: 2019-03-22
 * Time: 13:02 PM
 */

namespace bombants\backend\models\rights;

class Collection implements \IteratorAggregate, \JsonSerializable
{

    private $rights = [];



    public function add(RightsInterface $right) {
        $this->rights[$right->getName()] = $right;
    }

    public function jsonSerialize()
    {
        return array_map(function ($right) {
            return new \stdClass();
        }, $this->rights);
    }


    public function getIterator()
    {
        return $this->rights;
    }

}
