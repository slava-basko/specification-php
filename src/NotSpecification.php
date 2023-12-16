<?php

namespace Basko\Specification;

final class NotSpecification extends AbstractSpecification
{
    public function __construct(Specification $specification)
    {
        $this->container = $specification;
    }

    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return !$this->container->isSatisfiedBy($candidate);
    }
}
