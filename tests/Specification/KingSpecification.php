<?php

namespace Basko\SpecificationTest\Specification;

use Basko\Specification\AbstractSpecification;

class KingSpecification extends AbstractSpecification
{
    /**
     * @param \Basko\SpecificationTest\Value\PlayingCard $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return $candidate->rank === \Basko\SpecificationTest\Value\PlayingCard::RANK_KING;
    }
}