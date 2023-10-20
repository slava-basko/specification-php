<?php

namespace Basko\SpecificationTest\Specification;

use Basko\Specification\AbstractSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class PlayingCardSpecification extends AbstractSpecification
{
    private $suit;

    private $rank;

    public function __construct($suit, $rank)
    {
        if (!in_array($suit, PlayingCard::$possibleSuites)) {
            throw new \InvalidArgumentException('Unknown suit');
        }

        if (!in_array($rank, PlayingCard::$possibleRanks)) {
            throw new \InvalidArgumentException('Unknown rank');
        }

        $this->suit = $suit;
        $this->rank = $rank;
    }

    /**
     * @param PlayingCard $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        return $candidate->rank == $this->rank && $candidate->suit == $this->suit;
    }
}
