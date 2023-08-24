<?php

namespace Basko\SpecificationTest\TestCase;


use Basko\Specification\NotSpecification;
use Basko\Specification\TypedSpecification;
use Basko\SpecificationTest\Specification\AdultUserSpecification;
use Basko\SpecificationTest\Specification\ProductAvailableForSaleSpecification;
use Basko\SpecificationTest\Value\User;

class SpecificationTest extends BaseTest
{
    public function testSpecification()
    {
        $productAvailableForSale = new ProductAvailableForSaleSpecification();

        $this->assertTrue($productAvailableForSale->isSatisfiedBy(['created' => strtotime('-2 year')]));
        $this->assertFalse($productAvailableForSale->isSatisfiedBy(['created' => strtotime('-10 day')]));
    }

    public function testNotSpecification()
    {
        $productNotAvailableForSale = new NotSpecification(new ProductAvailableForSaleSpecification());

        $this->assertTrue($productNotAvailableForSale->isSatisfiedBy(['created' => strtotime('-10 day')]));
    }

    public function testRemainderUnsatisfiedBy()
    {
        $teen = new User(14);
        $adult = new User(25);

        $adultUserSpecification = new TypedSpecification(new AdultUserSpecification(), User::class);

        $this->assertFalse($adultUserSpecification->isSatisfiedBy($teen));

        $unsatisfiedAdultUserSpecification = $adultUserSpecification->remainderUnsatisfiedBy($teen);
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