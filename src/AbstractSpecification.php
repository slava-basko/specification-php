<?php

namespace Basko\Specification;

abstract class AbstractSpecification implements Specification
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function __invoke($candidate)
    {
        return $this->isSatisfiedBy($candidate);
    }

    /**
     * Returns remainder (unsatisfied) specifications.
     *
     * @param mixed $candidate
     * @return $this|null
     */
    public function remainderUnsatisfiedBy($candidate)
    {
        if (!$this->isSatisfiedBy($candidate))
            return $this;

        return null;
    }
}