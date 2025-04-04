<?php

namespace Basko\Specification;

/**
 * Negation of the inclusive disjunction
 */
final class NorSpecification extends GroupSpecification
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return (new NotSpecification(new OrSpecification($this->container)))->isSatisfiedBy($candidate);
    }
}
