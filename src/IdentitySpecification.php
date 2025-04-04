<?php

namespace Basko\Specification;

final class IdentitySpecification extends AbstractSpecification
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return (bool)$candidate;
    }
}
