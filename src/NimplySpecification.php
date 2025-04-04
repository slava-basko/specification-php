<?php

namespace Basko\Specification;

/**
 * Negation of material implication, material nonimplication
 */
final class NimplySpecification extends AbstractSpecification implements Binary
{
    /**
     * @param \Basko\Specification\Specification $a
     * @param \Basko\Specification\Specification $b
     */
    public function __construct(Specification $a, Specification $b)
    {
        $this->container = [$a, $b];
    }

    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return $this->container[0]->isSatisfiedBy($candidate) && !$this->container[1]->isSatisfiedBy($candidate);
    }
}
