<?php

namespace Basko\SpecificationTest\TestCase;


use Basko\Specification\AndSpecification;
use Basko\Specification\NotSpecification;
use Basko\SpecificationTest\Specification\KingSpecification;
use Basko\SpecificationTest\Specification\SpadesSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class AndSpecificationTest extends BaseTest
{
    public function testAndSpecification()
    {
        $spec = new AndSpecification([
            new SpadesSpecification(),
            new KingSpecification(),
        ]);

        $this->assertTrue(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_KING))
        );

        $this->assertFalse(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_QUEEN))
        );

        $notSpec = new NotSpecification($spec);
        $this->assertTrue(
            $notSpec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_QUEEN))
        );
    }
}