<?php

namespace Basko\Specification;

/**
 * Decorator for type assertion of specification's candidate and returned value.
 */
final class TypedSpecification extends AbstractSpecification
{
    /**
     * @var class-string|callable
     */
    private $type;

    /**
     * @param \Basko\Specification\Specification $specification
     * @param class-string|callable $type
     * @throws \Basko\Specification\Exception
     */
    public function __construct(Specification $specification, $type)
    {
        $this->container = $specification;

        if (\is_string($type) && !\class_exists($type)) {
            throw new Exception(\sprintf("Type '%s' not exist", $type));
        } elseif (!\is_string($type) && !\is_callable($type)) {
            throw new Exception(\sprintf(
                "Type must be a class-string or callable, got '%s'",
                \gettype($type)
            ));
        }

        $this->type = $type;
    }

    /**
     * @param mixed $candidate
     * @return void
     * @throws \Basko\Specification\Exception
     */
    private function assertCandidateType($candidate)
    {
        if (\is_callable($this->type)) {
            try {
                if (!\call_user_func($this->type, $candidate)) {
                    throw new Exception(\sprintf(
                        "%s<%s>::isSatisfiedBy() type check failed (callback returned falsy result), candidate '%s'",
                        \get_class($this),
                        \get_class($this->container),
                        \is_object($candidate) ? \get_class($candidate) : \var_export($candidate, true)
                    ));
                }
            } catch (\InvalidArgumentException $argumentException) {
                throw $argumentException;
            } catch (\Exception $exception) {
                throw new Exception(
                    \sprintf(
                        "%s<%s>::isSatisfiedBy() type check failed (%s), candidate '%s'",
                        \get_class($this),
                        \get_class($this->container),
                        $exception->getMessage(),
                        \is_object($candidate) ? \get_class($candidate) : \var_export($candidate, true)
                    ),
                    0,
                    $exception
                );
            }
        } elseif (!$candidate instanceof $this->type) {
            throw new Exception(\sprintf(
                "%s::isSatisfiedBy() expected '%s', got '%s'",
                \get_class($this->container),
                $this->type,
                \is_object($candidate) ? \get_class($candidate) : \gettype($candidate)
            ));
        }
    }

    /**
     * @param mixed $candidate
     * @return bool
     * @throws \Basko\Specification\Exception
     */
    public function isSatisfiedBy($candidate)
    {
        $this->assertCandidateType($candidate);
        $result = $this->container->isSatisfiedBy($candidate);
        Exception::assertReturnType($result, $this->container);

        return $result;
    }

    /**
     * @param $candidate
     * @return Specification|null
     * @throws \Basko\Specification\Exception
     */
    public function remainderUnsatisfiedBy($candidate)
    {
        $this->assertCandidateType($candidate);

        return $this->container->remainderUnsatisfiedBy($candidate);
    }
}
