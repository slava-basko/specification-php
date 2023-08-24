<?php

namespace Basko\SpecificationTest\Specification;


use Basko\Specification\AbstractSpecification;

class ProductAvailableForSaleSpecification extends AbstractSpecification
{
    public function isSatisfiedBy($candidate)
    {
        return value($candidate, 'created') < strtotime('-1 year');
    }
}