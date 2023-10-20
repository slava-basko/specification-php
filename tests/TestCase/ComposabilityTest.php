<?php

namespace Basko\SpecificationTest\TestCase;

use Basko\Specification\AndSpecification;
use Basko\Specification\NotSpecification;
use Basko\Specification\OrSpecification;
use Basko\SpecificationTest\Specification\PlayingCardSpecification;
use Basko\SpecificationTest\Specification\SpadesSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class ComposabilityTest extends BaseTest
{
    public function testDeepComposition()
    {
        $spadesButNot2or3 = new AndSpecification([
            new SpadesSpecification(),
            new NotSpecification(new OrSpecification([
                new PlayingCardSpecification(PlayingCard::SUIT_SPADES, PlayingCard::RANK_2),
                new PlayingCardSpecification(PlayingCard::SUIT_SPADES, PlayingCard::RANK_3),
            ])),
        ]);

        $this->assertTrue(
            $spadesButNot2or3->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_4))
        );
        $this->assertFalse(
            $spadesButNot2or3->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_2))
        );
    }
}