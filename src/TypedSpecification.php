<?php

namespace Basko\Specification;

/**
 * Decorator for type assertion of specification's candidate and returned value.
 */
class TypedSpecification extends AbstractSpecification
{
    /**
     * @var \Basko\Specification\Specification
     */
    private $specification;

    /**
     * @var class-string
     */
    private $type;

    /**
     * @param \Basko\Specification\Specification $specification
     * @param class-string $type
     * @throws \InvalidArgumentException
     */
    public function __construct(Specification $specification, $type)
    {
        $this->specification = $specification;

        if (!class_exists($type)) {
            throw new \InvalidArgumentException(sprintf("Type '%s' not exist", $type));
        }
        $this->type = $type;
    }

    /**
     * @param mixed $candidate
     * @return void
     */
    private function assertCandidateType($candidate)
    {
        if (!$candidate instanceof $this->type) {
            throw new \InvalidArgumentException(sprintf(
                "%s::isSatisfiedBy() expected '%s', got '%s'",
                get_class($this->specification),
                $this->type,
                is_object($candidate) ? get_class($candidate) : gettype($candidate)
            ));
        }
    }

    /**
     * @param mixed $candidate
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function isSatisfiedBy($candidate)
    {
        $this->assertCandidateType($candidate);
        $result = $this->specification->isSatisfiedBy($candidate);
        $this->assertReturnType($result, $this->specification);

        return $result;
    }

    /**
     * @param $candidate
     * @return Specification|Specification[]|null
     * @throws \InvalidArgumentException
     */
    public function remainderUnsatisfiedBy($candidate)
    {
        $this->assertCandidateType($candidate);

        return $this->specification->remainderUnsatisfiedBy($candidate);
    }
}
