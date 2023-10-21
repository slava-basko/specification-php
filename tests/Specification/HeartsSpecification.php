<?php

namespace Basko\SpecificationTest\Specification;

use Basko\Specification\AbstractSpecification;

class HeartsSpecification extends AbstractSpecification
{
    /**
     * @param \Basko\SpecificationTest\Value\PlayingCard $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return $candidate->suit === \Basko\SpecificationTest\Value\PlayingCard::SUIT_HEARTS;
    }
}