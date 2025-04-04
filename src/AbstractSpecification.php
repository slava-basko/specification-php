<?php

namespace Basko\Specification;

abstract class AbstractSpecification implements Specification
{
    /**
     * @var \Basko\Specification\Specification|\Basko\Specification\Specification[]|null
     */
    protected $container = null;

    /**
     * @param mixed $candidate
     * @return bool
     * @throws \Basko\Specification\Exception
     */
    public function __invoke($candidate)
    {
        $result = $this->isSatisfiedBy($candidate);
        Exception::assertReturnType($result, $this);

        return $result;
    }

    /**
     * Returns remainder (unsatisfied) specifications.
     *
     * @param mixed $candidate
     * @return \Basko\Specification\Specification|null
     */
    public function remainderUnsatisfiedBy($candidate)
    {
        if (!$this->isSatisfiedBy($candidate)) {
            return $this;
        }

        return null;
    }
}
