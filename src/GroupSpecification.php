<?php

namespace Basko\Specification;

abstract class GroupSpecification extends AbstractSpecification
{
    /**
     * Constructor for GroupSpecification.
     *
     * ```php
     * new AndSpecification(new Spec1(), new Spec2());
     * new AndSpecification([new Spec1(), new Spec2()]);
     * ```
     *
     * @param mixed $specifications Either an array of Specifications or individual Specification objects.
     * @throws \InvalidArgumentException If any item in the specifications array is not an instance
     *                                    of the Specification class.
     */
    public function __construct($specifications)
    {
        $specifications = Utils::flatten(\func_get_args());

        foreach ($specifications as $specification) {
            if (!$specification instanceof Specification) {
                throw new \InvalidArgumentException(\sprintf(
                    "Expected '%s', got '%s'",
                    Specification::class,
                    \is_object($specification) ? \get_class($specification) : \gettype($specification)
                ));
            }
        }

        $this->container = $specifications;
    }

    /**
     * @param mixed $candidate
     * @return \Basko\Specification\GroupSpecification|null
     */
    public function remainderUnsatisfiedBy($candidate)
    {
        if ($this->isSatisfiedBy($candidate)) {
            return null;
        } else {
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
        foreach ($this->container as $specification) {
            if (!$specification->isSatisfiedBy($candidate)) {
                $unsatisfied[] = $specification;
            }
        }

        return $unsatisfied;
    }
}
