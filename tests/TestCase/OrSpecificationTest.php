<?php

namespace Basko\SpecificationTest\TestCase;


use Basko\Specification\OrSpecification;
use Basko\SpecificationTest\Specification\ClubsSpecification;
use Basko\SpecificationTest\Specification\SpadesSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class OrSpecificationTest extends BaseTest
{
    public function testOrSpecification()
    {
        $spec = new OrSpecification([
            new SpadesSpecification(),
            new ClubsSpecification(),
        ]);

        $this->assertTrue(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_KING))
        );

        $this->assertTrue(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_CLUBS, PlayingCard::RANK_KING))
        );

        $this->assertFalse(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_HEARTS, PlayingCard::RANK_KING))
        );
    }
}