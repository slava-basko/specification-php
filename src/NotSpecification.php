<?php

namespace Basko\Specification;

class NotSpecification extends AbstractSpecification
{
    /**
     * @var \Basko\Specification\Specification
     */
    private $specification;

    public function __construct(Specification $specification)
    {
        $this->specification = $specification;
    }

    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return !$this->specification->isSatisfiedBy($candidate);
    }
}
