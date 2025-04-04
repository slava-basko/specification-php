<?php

namespace Basko\Specification;

interface Binary
{
    /**
     * @param \Basko\Specification\Specification $a
     * @param \Basko\Specification\Specification $b
     */
    public function __construct(Specification $a, Specification $b);
}
