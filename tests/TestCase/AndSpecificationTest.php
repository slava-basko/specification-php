<?php

namespace Basko\SpecificationTest\TestCase;


use Basko\Specification\AndSpecification;
use Basko\Specification\NotSpecification;
use Basko\SpecificationTest\Specification\ProductAvailableForUserSpecification;
use Basko\SpecificationTest\Specification\ProductInStockSpecification;

class AndSpecificationTest extends BaseTest
{
    public function testAndSpecification()
    {
        $productAvailableAndSoldableForUser = new AndSpecification([
            new ProductInStockSpecification(),
            new ProductAvailableForUserSpecification('CA'),
        ]);

        $this->assertTrue($productAvailableAndSoldableForUser->isSatisfiedBy([
            'store_qty' => 5,
            'countries' => ['CA', 'US', 'MX']
        ]));
        $this->assertTrue($productAvailableAndSoldableForUser->isSatisfiedBy([
            'warehouse_qty' => 5,
            'countries' => ['CA', 'US', 'MX']
        ]));

        $this->assertFalse($productAvailableAndSoldableForUser->isSatisfiedBy([
            'warehouse_qty' => 5,
            'countries' => ['UA', 'PL']
        ]));
    }

    public function testNotAndSpecification()
    {
        $productNotAvailableAndSoldableForUser = new NotSpecification(new AndSpecification([
            new ProductInStockSpecification(),
            new ProductAvailableForUserSpecification('CA'),
        ]));

        $this->assertTrue($productNotAvailableAndSoldableForUser->isSatisfiedBy([
            'store_qty' => 0,
            'countries' => ['CA', 'US', 'MX']
        ]));
    }
}