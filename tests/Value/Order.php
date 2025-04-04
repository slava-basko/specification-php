<?php

namespace Basko\SpecificationTest\Value;

class Order
{
    public $isShipped;
    public $isPaid;

    public function __construct($isShipped, $isPaid)
    {

        $this->isPaid = $isPaid;
        $this->isShipped = $isShipped;
    }

    public function isPaid()
    {
        return $this->isPaid;
    }

    public function isShipped()
    {
        return $this->isShipped;
    }
}
