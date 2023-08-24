<?php

namespace Basko\SpecificationTest\TestCase;

use Basko\Specification\TypedSpecification;
use Basko\SpecificationTest\Specification\AdultUserSpecification;
use Basko\SpecificationTest\Specification\InvalidSpecification;
use Basko\SpecificationTest\Value\User;

class TypedSpecificationTest extends BaseTest
{
    public function testTypedSpecificationConstructException()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Type '1' not exist"
        );

        new TypedSpecification(new AdultUserSpecification(), 1);
    }

    public function testTypedSpecificationException()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Basko\SpecificationTest\Specification\AdultUserSpecification::isSatisfiedBy() expected 'Basko\SpecificationTest\Value\User', got 'integer'"
        );

        $specification = new TypedSpecification(new AdultUserSpecification(), User::class);
        $specification->isSatisfiedBy(1);
    }

    public function testTypedSpecification()
    {
        $specification = new TypedSpecification(new AdultUserSpecification(), User::class);

        $this->assertTrue($specification->isSatisfiedBy(new User(20)));
        $this->assertFalse($specification->isSatisfiedBy(new User(16)));
    }

    public function testTypedSpecificationReturnType()
    {
        $this->setExpectedException(
            \LogicException::class,
            "Basko\SpecificationTest\Specification\InvalidSpecification::isSatisfiedBy() should return 'bool', got 'integer'"
        );

        $specification = new TypedSpecification(new InvalidSpecification(), User::class);
        $specification->isSatisfiedBy(new User(20));
    }

    public function testRemainderUnsatisfiedByTypesSpecificationFailed()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Basko\SpecificationTest\Specification\AdultUserSpecification::isSatisfiedBy() expected 'Basko\SpecificationTest\Value\User', got 'integer'"
        );

        $adultUserSpecification = new TypedSpecification(new AdultUserSpecification(), User::class);

        $adultUserSpecification->isSatisfiedBy(1);
    }
}