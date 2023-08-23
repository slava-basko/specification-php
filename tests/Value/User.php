<?php

namespace Basko\SpecificationTest\Value;

class User
{
    /**
     * @var int
     */
    private $age;

    /**
     * @param int $age
     */
    public function __construct($age)
    {
        $this->age = intval($age);
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }
}