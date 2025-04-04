<?php

namespace Basko\SpecificationTest\TestCase;

use Basko\Specification\Exception;
use Basko\Specification\MethodSpecification;
use Basko\Specification\PropertySpecification;
use Basko\SpecificationTest\Value\Order;

class HelperSpecificationTest extends BaseTest
{
    public function testMethodSpecification()
    {
        $this->assertTrue((new MethodSpecification('isShipped'))
            ->isSatisfiedBy(new Order(true, true)));

        $this->assertFalse((new MethodSpecification('isShipped'))
            ->isSatisfiedBy(new Order(false, true)));
    }

    public function testMethodSpecificationException()
    {
        $this->setExpectedException(
            Exception::class,
            "MethodSpecification::__construct() expects parameter 1 to be string, 'integer' given"
        );

        new MethodSpecification(1);
    }

    public function testMethodSpecificationException2()
    {
        $this->setExpectedException(
            Exception::class,
            "MethodSpecification::isSatisfiedBy() expects parameter 1 to be object, 'integer' given"
        );

        (new MethodSpecification('isShipped'))->isSatisfiedBy(1);
    }

    public function testObjectPropertySpecification()
    {
        $this->assertTrue((new PropertySpecification('isShipped'))
            ->isSatisfiedBy(new Order(true, true)));

        $this->assertFalse((new PropertySpecification('isShipped'))
            ->isSatisfiedBy(new Order(false, true)));
    }

    public function testArrayKeySpecification()
    {
        $this->assertTrue((new PropertySpecification('isShipped'))
            ->isSatisfiedBy(['isShipped' => true, 'isPaid' => false]));

        $this->assertFalse((new PropertySpecification('isShipped'))
            ->isSatisfiedBy(['isShipped' => false, 'isPaid' => false]));
    }

    public function testPropertySpecificationException()
    {
        $this->setExpectedException(
            Exception::class,
            "PropertySpecification::__construct() expects parameter 1 to be string, 'integer' given"
        );

        new PropertySpecification(1);
    }

    public function testPropertySpecificationException2()
    {
        $this->setExpectedException(
            Exception::class,
            "PropertySpecification::isSatisfiedBy() expects parameter 1 to be object or array, 'integer' given"
        );

        (new PropertySpecification('isShipped'))->isSatisfiedBy(1);
    }
}