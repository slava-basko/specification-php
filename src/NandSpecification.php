<?php

namespace Basko\Specification;

/**
 * A.k.a. Sheffer stroke (https://en.wikipedia.org/wiki/Sheffer_stroke)
 */
final class NandSpecification extends GroupSpecification
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return !((new AndSpecification($this->container))->isSatisfiedBy($candidate));
    }
}
