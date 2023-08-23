<?php

namespace Basko\SpecificationTest\Specification;

use Basko\Specification\AbstractSpecification;
use Basko\SpecificationTest\Value\User;

class AdultUserSpecification extends AbstractSpecification
{
    /**
     * @param User $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return $candidate->getAge() >= 18;
    }
}