<?php

namespace Basko\SpecificationTest\Specification;


use Basko\Specification\AbstractSpecification;

class CheepProductSpecification extends AbstractSpecification
{
    public function isSatisfiedBy($value)
    {
        return intval(val($value, 'price')) < 100;
    }
}