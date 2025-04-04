<?php

namespace Basko\Specification;

interface Nary
{
    /**
     * Any number of specifications, a.k.a. group
     *
     * ```php
     * new AndSpecification(new Spec1(), new Spec2());
     * new AndSpecification([new Spec1(), new Spec2()]);
     * ```
     *
     * @param mixed $specifications Either an array of Specifications or individual Specification objects..
     */
    public function __construct($specifications);
}
