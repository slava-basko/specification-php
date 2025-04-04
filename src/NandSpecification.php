<?php

namespace Basko\Specification;

/**
 * Negation of the conjunction , a.k.a. Sheffer stroke
 */
final class NandSpecification extends GroupSpecification
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return (new NotSpecification(new AndSpecification($this->container)))->isSatisfiedBy($candidate);
    }
}
