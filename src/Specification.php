<?php

namespace Basko\Specification;

interface Specification
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate);

    /**
     * @param mixed $candidate
     * @return Specification|Specification[]|null
     */
    public function remainderUnsatisfiedBy($candidate);
}
