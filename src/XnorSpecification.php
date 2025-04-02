<?php

namespace Basko\Specification;

final class XnorSpecification extends GroupSpecification
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return !((new XorSpecification($this->container))->isSatisfiedBy($candidate));
    }
}
