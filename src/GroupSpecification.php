<?php

namespace Basko\Specification;

abstract class GroupSpecification extends AbstractSpecification
{
    /**
     * @var Specification[]
     */
    protected $specifications = [];

    /**
     * @param Specification[] $specifications
     */
    public function __construct(array $specifications)
    {
        foreach ($specifications as $specification) {
            if (!$specification instanceof Specification) {
                throw new \InvalidArgumentException(sprintf(
                    "Expected '%s', got '%s'",
                    Specification::class,
                    is_object($specification) ? get_class($specification) : gettype($specification)
                ));
            }
        }

        $this->specifications = $specifications;
    }

    public function remainderUnsatisfiedBy($candidate)
    {
        if ($this->isSatisfiedBy($candidate))
            return null;
        else {
            // Constructs a GroupSpecification out of the specifications that have not been satisfied
            return new static($this->remaindersUnsatisfiedBy($candidate));
        }
    }

    /**
     * Evaluates every specification and return the ones that fail
     *
     * @param mixed $candidate
     * @return \Basko\Specification\Specification[]
     */
    private function remaindersUnsatisfiedBy($candidate)
    {
        $unsatisfied = [];
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($candidate))
                $unsatisfied[] = $specification;
        }

        return $unsatisfied;
    }
}
