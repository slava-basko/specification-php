<?php

namespace Basko\SpecificationTest\Specification;

use Basko\Specification\AbstractSpecification;

class ProductAvailableForUserSpecification extends AbstractSpecification
{
    private $userCountry;

    public function __construct($userCountry)
    {
        $this->userCountry = $userCountry;
    }

    public function isSatisfiedBy($candidate)
    {
        return in_array($this->userCountry, value($candidate, 'countries'));
    }
}