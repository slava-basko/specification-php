<?php

namespace Basko\SpecificationTest\Specification;

use Basko\Specification\AbstractSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class TrumpSuitSpecification extends AbstractSpecification
{
    private $suit;

    public function __construct($suit)
    {
        if (!in_array($suit, PlayingCard::$possibleSuites)) {
            throw new \InvalidArgumentException('Unknown suit');
        }

        $this->suit = $suit;
    }

    /**
     * @param PlayingCard $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return $candidate->suit == $this->suit;
    }
}
