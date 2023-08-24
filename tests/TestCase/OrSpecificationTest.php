<?php

namespace Basko\SpecificationTest\TestCase;


use Basko\Specification\OrSpecification;
use Basko\SpecificationTest\Specification\CheepProductSpecification;
use Basko\SpecificationTest\Specification\ProductAvailableForSaleSpecification;

class OrSpecificationTest extends BaseTest
{
    public function testOrSpecification()
    {
        $leftoverProductSpecification = new OrSpecification([
            new CheepProductSpecification(),
            new ProductAvailableForSaleSpecification(),
        ]);

        $this->assertTrue($leftoverProductSpecification->isSatisfiedBy([
            'price' => 10,
            'created' => strtotime('-1 day')
        ]));
        $this->assertTrue($leftoverProductSpecification->isSatisfiedBy([
            'price' => 1000,
            'created' => strtotime('-2 year')
        ]));
        $this->assertFalse($leftoverProductSpecification->isSatisfiedBy([
            'price' => 1000,
            'created' => strtotime('-1 day')
        ]));
    }
}