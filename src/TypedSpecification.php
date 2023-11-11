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
     * @var class-string|callable
     */
    private $type;

    /**
     * @param \Basko\Specification\Specification $specification
     * @param class-string|callable $type
     * @throws \InvalidArgumentException
     */
    public function __construct(Specification $specification, $type)
    {
        $this->specification = $specification;

        if (\is_string($type) && !\class_exists($type)) {
            throw new \InvalidArgumentException(\sprintf("Type '%s' not exist", $type));
        } elseif (!\is_string($type) && !\is_callable($type)) {
            throw new \InvalidArgumentException(\sprintf(
                "Type must be a class-string or callable, got '%s'",
                \gettype($type)
            ));
        }

        $this->type = $type;
    }

    /**
     * @param mixed $candidate
     * @return void
     * @throws \InvalidArgumentException
     */
    private function assertCandidateType($candidate)
    {
        if (\is_callable($this->type)) {
            try {
                if (!\call_user_func($this->type, $candidate)) {
                    throw new \InvalidArgumentException(\sprintf(
                        "TypedSpecification<%s>::isSatisfiedBy() type check failed (callback returned falsy result), candidate '%s'",
                        \get_class($this->specification),
                        \is_object($candidate) ? \get_class($candidate) : \var_export($candidate, true)
                    ));
                }
            } catch (\InvalidArgumentException $argumentException) {
                throw $argumentException;
            } catch (\Exception $exception) {
                throw new \InvalidArgumentException(
                    \sprintf(
                        "TypedSpecification<%s>::isSatisfiedBy() type check failed (%s), candidate '%s'",
                        \get_class($this->specification),
                        $exception->getMessage(),
                        \is_object($candidate) ? \get_class($candidate) : \var_export($candidate, true)
                    ),
                    0,
                    $exception
                );
            }
        } elseif (!$candidate instanceof $this->type) {
            throw new \InvalidArgumentException(\sprintf(
                "%s::isSatisfiedBy() expected '%s', got '%s'",
                \get_class($this->specification),
                $this->type,
                \is_object($candidate) ? \get_class($candidate) : \gettype($candidate)
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
     * @return Specification|null
     * @throws \InvalidArgumentException
     */
    public function remainderUnsatisfiedBy($candidate)
    {
        $this->assertCandidateType($candidate);

        return $this->specification->remainderUnsatisfiedBy($candidate);
    }
}
