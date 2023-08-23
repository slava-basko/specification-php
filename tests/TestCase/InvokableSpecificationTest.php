<?php

namespace Basko\SpecificationTest\TestCase;


use Basko\SpecificationTest\Specification\ProductInStockSpecification;

class InvokableSpecificationTest extends BaseTest
{
    public function test_specification()
    {
        $productAvailableSpecification = new ProductInStockSpecification();

        $this->assertEquals(
            [1 => ['id' => 456, 'store_qty' => 5]],
            array_filter(
                [
                    [
                        'id' => 123,
                        'store_qty' => 0,
                    ],
                    [
                        'id' => 456,
                        'store_qty' => 5,
                    ],
                ],
                $productAvailableSpecification
            )
        );
    }
}