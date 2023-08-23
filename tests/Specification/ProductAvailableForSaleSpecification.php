<?php

namespace Basko\SpecificationTest\Specification;


use Basko\Specification\AbstractSpecification;

class ProductAvailableForSaleSpecification extends AbstractSpecification
{
    public function isSatisfiedBy($value)
    {
        return val($value, 'created') < strtotime('-1 year');
    }
}