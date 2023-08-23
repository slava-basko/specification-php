<?php

namespace Basko\SpecificationTest\TestCase;


use Basko\Specification\AndSpecification;
use Basko\Specification\NotSpecification;
use Basko\SpecificationTest\Specification\CheepProductSpecification;
use Basko\SpecificationTest\Specification\ProductAvailableForSaleSpecification;
use Basko\SpecificationTest\Specification\ProductInStockSpecification;

class GroupSpecificationTest extends BaseTest
{
    public function test_group_specification_invalid_values()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Expected 'Basko\Specification\Specification', got 'stdClass'"
        );

        new AndSpecification([
            new ProductInStockSpecification(),
            new \stdClass(),
        ]);
    }

    public function test_group_specification_invalid_values_2()
    {
        $this->setExpectedException(
            \InvalidArgumentException::class,
            "Expected 'Basko\Specification\Specification', got 'string'"
        );

        new AndSpecification([
            new ProductInStockSpecification(),
            'unknown',
        ]);
    }

    public function testRemainderUnsatisfiedBy()
    {
        $productAvailableForSale = new ProductAvailableForSaleSpecification();
        $cheepProductSpecification = new CheepProductSpecification();

        $cheepProductAvailableForSale = new AndSpecification([
            $productAvailableForSale,
            $cheepProductSpecification,
        ]);

        $product = [
            'created' => strtotime('-2 year'),
            'price' => 200
        ];

        $this->assertFalse($cheepProductAvailableForSale->isSatisfiedBy($product));

        // returns the [$cheepProductSpecification]
        $unfulfilledSpec = $cheepProductAvailableForSale->remainderUnsatisfiedBy($product);
        $expensiveProductSpecification = new NotSpecification($unfulfilledSpec);
        $this->assertTrue($expensiveProductSpecification->isSatisfiedBy($product));
    }

    public function testRemainderUnsatisfiedByFailed() {
        $productAvailableForSale = new ProductAvailableForSaleSpecification();
        $cheepProductSpecification = new CheepProductSpecification();

        $cheepProductAvailableForSale = new AndSpecification([
            $productAvailableForSale,
            $cheepProductSpecification,
        ]);

        $product = [
            'created' => strtotime('-2 year'),
            'price' => 50
        ];

        $this->assertTrue($cheepProductAvailableForSale->isSatisfiedBy($product));

        $this->assertNull($cheepProductAvailableForSale->remainderUnsatisfiedBy($product));
    }
}