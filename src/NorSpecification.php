<?php

namespace Basko\Specification;

final class NorSpecification extends GroupSpecification
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return !((new OrSpecification($this->container))->isSatisfiedBy($candidate));
    }
}
