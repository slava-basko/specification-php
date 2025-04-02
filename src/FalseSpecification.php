<?php

namespace Basko\Specification;

class FalseSpecification extends AbstractSpecification
{
    /**
     * @param mixed $candidate
     * @return false
     */
    public function isSatisfiedBy($candidate)
    {
        return false;
    }
}
