<?php

namespace Basko\Specification;

/**
 * Negation
 */
final class NotSpecification extends AbstractSpecification implements Unary
{
    /**
     * @param \Basko\Specification\Specification $specification
     */
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
