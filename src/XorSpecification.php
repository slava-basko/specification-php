<?php

namespace Basko\Specification;

/**
 * Exclusive disjunction (OR)
 */
final class XorSpecification extends GroupSpecification
{
    /**
     * @param mixed $candidate
     * @return bool
     * @throws \Basko\Specification\Exception
     */
    public function isSatisfiedBy($candidate)
    {
        $satisfiedCount = 0;

        foreach ($this->container as $specification) {
            $result = $specification->isSatisfiedBy($candidate);
            Exception::assertReturnType($result, $specification);
            if ($result) {
                $satisfiedCount++;
            }
        }

        // With multiple inputs, XOR is true if and only if the number of true inputs is odd
        return $satisfiedCount % 2 === 1;
    }
}
