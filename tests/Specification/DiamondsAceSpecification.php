<?php

namespace Basko\SpecificationTest\Specification;

use Basko\Specification\AbstractSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class DiamondsAceSpecification extends AbstractSpecification
{
    /**
     * @param \Basko\SpecificationTest\Value\PlayingCard $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return $candidate->suit == PlayingCard::SUIT_DIAMONDS && $candidate->rank == PlayingCard::RANK_ACE;
    }
}