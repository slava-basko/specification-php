<?php

namespace Basko\Specification;

final class TrueSpecification extends AbstractSpecification
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
