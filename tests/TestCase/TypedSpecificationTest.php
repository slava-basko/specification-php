<?php

namespace Basko\SpecificationTest\TestCase;

use Basko\Specification\TypedSpecification;
use Basko\SpecificationTest\Specification\AdultUserSpecification;
use Basko\SpecificationTest\Value\User;

class TypedSpecificationTest extends BaseTest
{
    public function test_typed_specification_construct_exception()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Type '1' not exist"
        );

        new TypedSpecification(new AdultUserSpecification(), 1);
    }

    public function test_typed_specification_exception()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Expected 'Basko\SpecificationTest\Value\User', got 'integer'"
        );

        $specification = new TypedSpecification(new AdultUserSpecification(), User::class);
        $specification->isSatisfiedBy(1);
    }

    public function test_typed_specification()
    {
        $specification = new TypedSpecification(new AdultUserSpecification(), User::class);

        $this->assertTrue($specification->isSatisfiedBy(new User(20)));
        $this->assertFalse($specification->isSatisfiedBy(new User(16)));
    }
}