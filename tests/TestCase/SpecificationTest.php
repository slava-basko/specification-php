<?php

namespace Basko\SpecificationTest\TestCase;


use Basko\Specification\AndSpecification;
use Basko\Specification\NotSpecification;
use Basko\SpecificationTest\Specification\AdultUserSpecification;
use Basko\SpecificationTest\Specification\CheepProductSpecification;
use Basko\SpecificationTest\Specification\ProductAvailableForSaleSpecification;
use Basko\SpecificationTest\Value\User;

class SpecificationTest extends BaseTest
{
    public function test_specification()
    {
        $productAvailableForSale = new ProductAvailableForSaleSpecification();

        $this->assertTrue($productAvailableForSale->isSatisfiedBy(['created' => strtotime('-2 year')]));
        $this->assertFalse($productAvailableForSale->isSatisfiedBy(['created' => strtotime('-10 day')]));
    }

    public function test_not_specification()
    {
        $productNotAvailableForSale = new NotSpecification(new ProductAvailableForSaleSpecification());

        $this->assertTrue($productNotAvailableForSale->isSatisfiedBy(['created' => strtotime('-10 day')]));
    }

    public function test_invokable_specification()
    {
        $productAvailableForSale = new ProductAvailableForSaleSpecification();

        $this->assertTrue($productAvailableForSale(['created' => strtotime('-2 year')]));
    }

    public function testRemainderUnsatisfiedBy()
    {
        $youth = new User(14);
        $adult = new User(25);

        $adultUserSpecification = new AdultUserSpecification();

        $this->assertFalse($adultUserSpecification->isSatisfiedBy($youth));

        $unsatisfiedAdultUserSpecification = $adultUserSpecification->remainderUnsatisfiedBy($youth);
        $this->assertInstanceOf(AdultUserSpecification::class, $unsatisfiedAdultUserSpecification);

        $this->assertTrue($unsatisfiedAdultUserSpecification->isSatisfiedBy($adult));
    }

    public function testRemainderUnsatisfiedByFailed()
    {
        $adult = new User(25);

        $adultUserSpecification = new AdultUserSpecification();

        $this->assertTrue($adultUserSpecification->isSatisfiedBy($adult));

        $this->assertNull($adultUserSpecification->remainderUnsatisfiedBy($adult));
    }
}