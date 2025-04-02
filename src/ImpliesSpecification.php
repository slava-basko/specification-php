<?php

namespace Basko\Specification;

final class ImpliesSpecification extends AbstractSpecification
{
    /**
     * @var \Basko\Specification\Specification
     */
    private $a;

    /**
     * @var \Basko\Specification\Specification
     */
    private $b;

    /**
     * @param \Basko\Specification\Specification $a
     * @param \Basko\Specification\Specification $b
     */
    public function __construct(Specification $a, Specification $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return !$this->a->isSatisfiedBy($candidate) || $this->b->isSatisfiedBy($candidate);
    }
}
