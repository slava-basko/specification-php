<?php

namespace Basko\Specification;

/**
 * Negation og the exclusive disjunction
 */
final class XnorSpecification extends GroupSpecification
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return (new NotSpecification(new XorSpecification($this->container)))->isSatisfiedBy($candidate);
    }
}
