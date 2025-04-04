<?php

namespace Basko\Specification;

interface Unary
{
    /**
     * @param \Basko\Specification\Specification $specification
     */
    public function __construct(Specification $specification);
}
