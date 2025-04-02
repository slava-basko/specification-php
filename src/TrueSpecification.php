<?php

namespace Basko\Specification;

class TrueSpecification extends AbstractSpecification
{
    /**
     * @param mixed $candidate
     * @return true
     */
    public function isSatisfiedBy($candidate)
    {
        return true;
    }
}
