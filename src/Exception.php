<?php

namespace Basko\Specification;

class Exception extends \Exception
{
    /**
     * @param $value
     * @return void
     * @throws \Basko\Specification\Exception
     */
    public static function assertSpecification($value)
    {
        if (!$value instanceof Specification) {
            throw new Exception(\sprintf(
                "Expected '%s', got '%s'",
                Specification::class,
                \is_object($value) ? \get_class($value) : \gettype($value)
            ));
        }
    }

    /**
     * @param mixed $result
     * @param mixed $specification
     * @return void
     * @throws \Basko\Specification\Exception
     */
    public static function assertReturnType($result, Specification $specification)
    {
        if (!\is_bool($result)) {
            throw new Exception(\sprintf(
                "%s::isSatisfiedBy() should return 'bool', got '%s'",
                \get_class($specification),
                \is_object($result) ? \get_class($result) : \gettype($result)
            ));
        }
    }

    /**
     * @param mixed $value
     * @param string $callee
     * @param int $parameterPosition
     * @return void
     * @throws static
     */
    public static function assertString($value, $callee, $parameterPosition)
    {
        if (!\is_string($value)) {
            throw new static(
                \sprintf(
                    "%s() expects parameter %d to be string, '%s' given",
                    $callee,
                    $parameterPosition,
                    \is_object($value) ? \get_class($value) : \gettype($value)
                )
            );
        }
    }

    /**
     * @param mixed $value
     * @param string $callee
     * @param int $parameterPosition
     * @return void
     * @throws static
     */
    public static function assertObject($value, $callee, $parameterPosition)
    {
        if (!\is_object($value)) {
            throw new static(
                \sprintf(
                    "%s() expects parameter %d to be object, '%s' given",
                    $callee,
                    $parameterPosition,
                    \is_object($value) ? \get_class($value) : \gettype($value)
                )
            );
        }
    }

    /**
     * @param mixed $value
     * @param string $callee
     * @param int $parameterPosition
     * @return void
     * @throws static
     */
    public static function assertObjectOrArray($value, $callee, $parameterPosition)
    {
        if (!\is_object($value) && !\is_array($value)) {
            throw new static(
                \sprintf(
                    "%s() expects parameter %d to be object or array, '%s' given",
                    $callee,
                    $parameterPosition,
                    \is_object($value) ? \get_class($value) : \gettype($value)
                )
            );
        }
    }
}
