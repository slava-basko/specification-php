<?php

namespace Basko\Specification;

final class PropertySpecification extends AbstractSpecification
{
    /**
     * @var string
     */
    private $property;

    /**
     * @param string $property
     * @throws \Basko\Specification\Exception
     */
    public function __construct($property)
    {
        Exception::assertString($property, __METHOD__, 1);

        $this->property = $property;
    }

    /**
     * @param object|array $candidate
     * @return bool
     * @throws \Basko\Specification\Exception
     */
    public function isSatisfiedBy($candidate)
    {
        Exception::assertObjectOrArray($candidate, __METHOD__, 1);

        if (\is_object($candidate)) {
            $result = (bool)$candidate->{$this->property};
        } else {
            $result = (bool)$candidate[$this->property];
        }

        return $result;
    }
}
