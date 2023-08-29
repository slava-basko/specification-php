<?php

namespace Basko\SpecificationTest\TestCase;

use Basko\Specification\AndSpecification;
use Basko\Specification\OrSpecification;
use Basko\Specification\TypedSpecification;
use Basko\SpecificationTest\Specification\PlayingCardSpecification;
use Basko\SpecificationTest\Specification\TrumpSuitSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class PlayingCardTest extends BaseTest
{
    public function testPlayingCard()
    {
        $spadeKindSpecification = new TypedSpecification(
            new PlayingCardSpecification(PlayingCard::SUIT_SPADES, PlayingCard::RANK_KING),
            PlayingCard::class
        );
        $spadeQueenSpecification = new TypedSpecification(
            new PlayingCardSpecification(PlayingCard::SUIT_SPADES, PlayingCard::RANK_QUEEN),
            PlayingCard::class
        );

        $trumpSpecification = new TypedSpecification(
            new TrumpSuitSpecification(PlayingCard::SUIT_SPADES),
            PlayingCard::class
        );

        $trumpSpadeKindSpecification = new AndSpecification([
            $spadeKindSpecification,
            $trumpSpecification,
        ]);

        $trumpSpadeQueenSpecification = new AndSpecification([
            $spadeQueenSpecification,
            $trumpSpecification,
        ]);

        $trumpSpadeKindOrQueenSpecification = new OrSpecification([
            $trumpSpadeKindSpecification,
            $trumpSpadeQueenSpecification
        ]);

        $this->assertTrue(
            $trumpSpadeKindSpecification->isSatisfiedBy(
                new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_KING)
            )
        );

        $this->assertTrue(
            $trumpSpadeQueenSpecification->isSatisfiedBy(
                new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_QUEEN)
            )
        );

        $this->assertTrue(
            $trumpSpadeKindOrQueenSpecification->isSatisfiedBy(
                new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_QUEEN)
            )
        );
    }
}
