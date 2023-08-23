<?php

namespace Basko\Specification;

/**
 * Decorator for type assertion of specification's candidate.
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
     * @param $candidate
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function isSatisfiedBy($candidate)
    {
        if (!$candidate instanceof $this->type) {
            throw new \InvalidArgumentException(sprintf(
                "Expected '%s', got '%s'",
                $this->type,
                is_object($candidate) ? get_class($candidate) : gettype($candidate)
            ));
        }

        return $this->specification->isSatisfiedBy($candidate);
    }
}