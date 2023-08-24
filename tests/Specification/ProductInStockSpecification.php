<?php

namespace Basko\SpecificationTest\Specification;


use Basko\Specification\AbstractSpecification;

class ProductInStockSpecification extends AbstractSpecification
{
    public function isSatisfiedBy($candidate)
    {
        return intval(value($candidate, 'store_qty')) > 0 || intval(value($candidate, 'warehouse_qty')) > 0;
    }
}