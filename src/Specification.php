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
     * @return bool
     */
    public function __invoke($candidate);
}