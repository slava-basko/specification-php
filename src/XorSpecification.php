<?php

namespace Basko\Specification;

final class XorSpecification extends GroupSpecification
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        $satisfiedCount = 0;

        foreach ($this->container as $specification) {
            $result = $specification->isSatisfiedBy($candidate);
            $this->assertReturnType($result, $specification);
            if ($result) {
                $satisfiedCount++;
            }
        }

        return $satisfiedCount % 2 === 1;
    }
}
