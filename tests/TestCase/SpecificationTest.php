<?php

namespace Basko\SpecificationTest\TestCase;


use Basko\Specification\NotSpecification;
use Basko\SpecificationTest\Specification\DiamondsAceSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class SpecificationTest extends BaseTest
{
    public function testSpecification()
    {
        $spec = new DiamondsAceSpecification();

        $this->assertTrue(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_DIAMONDS, PlayingCard::RANK_ACE))
        );

        $this->assertNull(
            $spec->remainderUnsatisfiedBy(new PlayingCard(PlayingCard::SUIT_DIAMONDS, PlayingCard::RANK_ACE))
        );

        $this->assertFalse(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_ACE))
        );

        $this->assertEquals(
            new DiamondsAceSpecification(),
            $spec->remainderUnsatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_ACE))
        );
    }

    public function testNotSpecification()
    {
        $spec = new NotSpecification(new DiamondsAceSpecification());

        $this->assertTrue(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_ACE))
        );

        $this->assertFalse(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_DIAMONDS, PlayingCard::RANK_ACE))
        );
    }
}