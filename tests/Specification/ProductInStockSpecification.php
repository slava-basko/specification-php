<?php

namespace Basko\SpecificationTest\Specification;


use Basko\Specification\AbstractSpecification;

class ProductInStockSpecification extends AbstractSpecification
{
    public function isSatisfiedBy($value)
    {
        return intval(val($value, 'store_qty')) > 0 || intval(val($value, 'warehouse_qty')) > 0;
    }
}