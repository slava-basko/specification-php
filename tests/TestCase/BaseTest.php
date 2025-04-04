<?php

namespace Basko\SpecificationTest\TestCase;


use Basko\Specification\Exception;
use PHPUnit\Framework\TestCase;
use RuntimeException;

abstract class BaseTest extends TestCase
{
    protected function mock($class)
    {
        if (method_exists($this, 'getMock')) {
            return $this->getMock($class);
        }

        return $this->createMock($class);
    }

    /**
     * @param $exceptionClass
     * @param $exceptionMessage
     * @param $exceptionCode
     * @return void
     * @throws \Basko\Specification\Exception
     */
    public function setExpectedException($exceptionClass, $exceptionMessage = '', $exceptionCode = 0)
    {
        if (method_exists($this, 'expectException')) {
            $this->expectException($exceptionClass);
            $this->expectExceptionMessage($exceptionMessage);
            $this->expectExceptionCode($exceptionCode);
        } else if (method_exists(parent::class, 'setExpectedException')) {
            parent::setExpectedException($exceptionClass, $exceptionMessage, $exceptionCode);
        } else {
            throw new Exception("Don't know how to expect exceptions");
        }
    }
}
