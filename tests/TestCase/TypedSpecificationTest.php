<?php

namespace Basko\SpecificationTest\TestCase;

use Basko\Specification\TypedSpecification;
use Basko\SpecificationTest\Specification\DiamondsAceSpecification;
use Basko\SpecificationTest\Specification\InvalidSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class TypedSpecificationTest extends BaseTest
{
    public function testTypedSpecificationConstructException()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Type '1' not exist"
        );

        new TypedSpecification(new DiamondsAceSpecification(), 1);
    }

    public function testTypedSpecificationException()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Basko\SpecificationTest\Specification\DiamondsAceSpecification::isSatisfiedBy() expected 'Basko\SpecificationTest\Value\PlayingCard', got 'integer'"
        );

        $spec = new TypedSpecification(new DiamondsAceSpecification(), PlayingCard::class);
        $spec->isSatisfiedBy(1);
    }

    public function testTypedSpecification()
    {
        $spec = new TypedSpecification(new DiamondsAceSpecification(), PlayingCard::class);

        $this->assertTrue(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_DIAMONDS, PlayingCard::RANK_ACE))
        );
    }

    public function testTypedSpecificationReturnType()
    {
        $this->setExpectedException(
            \LogicException::class,
            "Basko\SpecificationTest\Specification\InvalidSpecification::isSatisfiedBy() should return 'bool', got 'integer'"
        );

        $spec = new TypedSpecification(new InvalidSpecification(), PlayingCard::class);
        $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_DIAMONDS, PlayingCard::RANK_ACE));
    }
}