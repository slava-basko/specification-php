<?php

namespace Basko\Specification;

final class FalseSpecification extends AbstractSpecification
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
