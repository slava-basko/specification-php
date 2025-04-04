<?php

namespace Basko\Specification;

/**
 * Inclusive disjunction
 */
final class OrSpecification extends GroupSpecification
{
    /**
     * @param mixed $candidate
     * @return bool
     * @throws \Basko\Specification\Exception
     */
    public function isSatisfiedBy($candidate)
    {
        foreach ($this->container as $specification) {
            $result = $specification->isSatisfiedBy($candidate);
            Exception::assertReturnType($result, $specification);
            if ($result) {
                return true;
            }
        }

        return false;
    }
}
