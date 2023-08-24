<?php

namespace Basko\SpecificationTest\Specification;


use Basko\Specification\AbstractSpecification;

class CheepProductSpecification extends AbstractSpecification
{
    public function isSatisfiedBy($candidate)
    {
        return intval(value($candidate, 'price')) < 100;
    }
}