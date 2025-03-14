<?php

namespace Basko\SpecificationTest\TestCase;

use Basko\Specification\TypedSpecification;
use Basko\SpecificationTest\Specification\DiamondsAceArraySpecification;
use Basko\SpecificationTest\Specification\DiamondsAceSpecification;
use Basko\SpecificationTest\Specification\InvalidSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class TypedSpecificationTest extends BaseTest
{
    public function testTypedSpecificationConstructException()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Type must be a class-string or callable, got 'integer'"
        );

        new TypedSpecification(new DiamondsAceSpecification(), 1);
    }

    public function testTypedSpecificationConstructExceptionTypeNotExist()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Type 'SomeClass' not exist"
        );

        new TypedSpecification(new DiamondsAceSpecification(), 'SomeClass');
    }

    public function testTypedSpecificationException()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "DiamondsAceSpecification::isSatisfiedBy() expected 'Basko\SpecificationTest\Value\PlayingCard', got 'integer'"
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

        $this->assertFalse(
            $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_DIAMONDS, PlayingCard::RANK_KING))
        );
    }

    public function testTypedSpecificationReturnType()
    {
        $this->setExpectedException(
            \LogicException::class,
            "InvalidSpecification::isSatisfiedBy() should return 'bool', got 'integer'"
        );

        $spec = new TypedSpecification(new InvalidSpecification(), PlayingCard::class);
        $spec->isSatisfiedBy(new PlayingCard(PlayingCard::SUIT_DIAMONDS, PlayingCard::RANK_ACE));
    }

    public function testTypedSpecificationWithCallable()
    {
        $spec = new TypedSpecification(new DiamondsAceArraySpecification(), function ($candidate) {
            if (!array_key_exists('suit', $candidate) || !array_key_exists('rank', $candidate)) {
                return false;
            }

            return true;
        });

        $this->assertTrue(
            $spec->isSatisfiedBy(['suit' => PlayingCard::SUIT_DIAMONDS, 'rank' => PlayingCard::RANK_ACE])
        );

        $this->setExpectedException(
            \LogicException::class,
            "TypedSpecification<Basko\SpecificationTest\Specification\DiamondsAceArraySpecification>::isSatisfiedBy() type check failed (callback returned falsy result)"
        );
        $spec->isSatisfiedBy(['suit' => PlayingCard::SUIT_DIAMONDS]);
    }

    public function testTypedSpecificationWithCallableAndException()
    {
        $spec = new TypedSpecification(new DiamondsAceArraySpecification(), function ($candidate) {
            throw new \Exception('error inside');
        });

        $this->setExpectedException(
            \LogicException::class,
            "TypedSpecification<Basko\SpecificationTest\Specification\DiamondsAceArraySpecification>::isSatisfiedBy() type check failed (error inside)"
        );
        $spec->isSatisfiedBy(['suit' => PlayingCard::SUIT_DIAMONDS]);
    }

    public function testTypedSpecificationRemainder()
    {
        $card = new PlayingCard(PlayingCard::SUIT_DIAMONDS, PlayingCard::RANK_KING);

        $spec = new TypedSpecification(new DiamondsAceSpecification(), PlayingCard::class);
        $spec->isSatisfiedBy($card);

        $this->assertEquals(
            new DiamondsAceSpecification(),
            $spec->remainderUnsatisfiedBy($card)
        );
    }
}