<?php

namespace Basko\SpecificationTest\TestCase;

use Basko\Specification\AndSpecification;
use Basko\Specification\Exception;
use Basko\Specification\NorSpecification;
use Basko\Specification\NotSpecification;
use Basko\Specification\OrSpecification;
use Basko\Specification\TypedSpecification;
use Basko\Specification\Utils;
use Basko\SpecificationTest\Specification\HeartsSpecification;
use Basko\SpecificationTest\Specification\PlayingCardSpecification;
use Basko\SpecificationTest\Specification\SpadesSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class ComposabilityTest extends BaseTest
{
    /**
     * @var \Basko\Specification\OrSpecification
     */
    private $spec;

    /**
     * @before
     */
    public function setupSpec()
    {
        // Card of spades and not (two or three of spades), or (card of hearts and not (two or three of hearts))

        $this->spec = new OrSpecification([
            new AndSpecification([
                new SpadesSpecification(),
                new NotSpecification(new OrSpecification([
                    new PlayingCardSpecification(PlayingCard::SUIT_SPADES, PlayingCard::RANK_2),
                    new PlayingCardSpecification(PlayingCard::SUIT_SPADES, PlayingCard::RANK_3),
                ])),
            ]),
            new AndSpecification([
                new HeartsSpecification(),
                new NorSpecification([
                    new PlayingCardSpecification(PlayingCard::SUIT_HEARTS, PlayingCard::RANK_2),
                    new PlayingCardSpecification(PlayingCard::SUIT_HEARTS, PlayingCard::RANK_3),
                ]),
            ]),
        ]);
    }

    public function testDeepComposition()
    {
        $this->assertTrue(
            $this->spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_4))
        );

        $this->assertFalse(
            $this->spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_2))
        );

        $this->assertTrue(
            $this->spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_HEARTS, PlayingCard::RANK_4))
        );

        $this->assertFalse(
            $this->spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_HEARTS, PlayingCard::RANK_2))
        );
    }

    public function testTypedDeepComposition()
    {
        $spec = new TypedSpecification($this->spec, PlayingCard::class);

        $this->assertTrue(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_4))
        );

        $this->assertFalse(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_SPADES, PlayingCard::RANK_2))
        );

        $this->setExpectedException(
            Exception::class,
            "OrSpecification::isSatisfiedBy() expected 'Basko\SpecificationTest\Value\PlayingCard', got 'integer'"
        );
        $spec->isSatisfiedBy(1);
    }

    public function testSpecName()
    {
        $this->assertEquals([
            'or' => [
                [
                    'and' => [
                        'spades',
                        ['not' => ['or' => ['♠_2', '♠_3']]],
                    ],
                ],
                [
                    'and' => [
                        'hearts',
                        ['nor' => ['♥_2', '♥_3']],
                    ],
                ],
            ],
        ], Utils::toSnakeCase($this->spec));
    }
}