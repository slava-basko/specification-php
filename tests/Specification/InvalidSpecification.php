<?php

namespace Basko\SpecificationTest\Specification;

use Basko\Specification\Specification;

class InvalidSpecification implements Specification
{
    public function isSatisfiedBy($candidate)
    {
        return 1;
    }

    public function remainderUnsatisfiedBy($candidate)
    {
        return null;
    }
}