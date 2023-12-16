<?php

namespace Basko\Specification;

final class OrSpecification extends GroupSpecification
{
    /**
     * @param mixed $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        foreach ($this->container as $specification) {
            $result = $specification->isSatisfiedBy($candidate);
            $this->assertReturnType($result, $specification);
            if ($result) {
                return true;
            }
        }

        return false;
    }
}
