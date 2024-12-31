<?php

namespace Basko\Specification;

abstract class AbstractSpecification implements Specification
{
    /**
     * @var \Basko\Specification\Specification|\Basko\Specification\Specification[]|null
     */
    protected $container = null;

    /**
     * @param mixed $result
     * @param \Basko\Specification\Specification|null $specification
     * @return void
     */
    protected function assertReturnType($result, Specification $specification = null)
    {
        if (!\is_bool($result)) {
            throw new \LogicException(\sprintf(
                "%s::isSatisfiedBy() should return 'bool', got '%s'",
                ($specification instanceof Specification) ? \get_class($specification) : \get_class($this),
                \is_object($result) ? \get_class($result) : \gettype($result)
            ));
        }
    }

    /**
     * @param mixed $candidate
     * @return bool
     */
    public function __invoke($candidate)
    {
        $result = $this->isSatisfiedBy($candidate);
        $this->assertReturnType($result);

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
