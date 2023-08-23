<?php

namespace Basko\Specification;


final class AndSpecification extends GroupSpecification
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($candidate)) {
                return false;
            }
        }

        return true;
    }
}