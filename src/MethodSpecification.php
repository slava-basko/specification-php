<?php

namespace Basko\Specification;

final class MethodSpecification extends AbstractSpecification
{
    /**
     * @var string
     */
    private $method;

    /**
     * @param string $method
     * @throws \Basko\Specification\Exception
     */
    public function __construct($method)
    {
        Exception::assertString($method, __METHOD__, 1);

        $this->method = $method;
    }

    /**
     * @param object $candidate
     * @return bool
     * @throws \Basko\Specification\Exception
     */
    public function isSatisfiedBy($candidate)
    {
        Exception::assertObject($candidate, __METHOD__, 1);

        return (bool)$candidate->{$this->method}();
    }
}
