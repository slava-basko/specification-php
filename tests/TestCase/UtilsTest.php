<?php

namespace Basko\SpecificationTest\TestCase;

use Basko\Specification\AndSpecification;
use Basko\Specification\OrSpecification;
use Basko\Specification\TypedSpecification;
use Basko\Specification\Utils;
use Basko\SpecificationTest\Specification\ClubsSpecification;
use Basko\SpecificationTest\Specification\SnakeCase\PDFLoadableSpecification;
use Basko\SpecificationTest\Specification\SnakeCase\Some4Numbers234Specification;
use Basko\SpecificationTest\Specification\SnakeCase\SomeHTMLSpecification;
use Basko\SpecificationTest\Specification\SnakeCase\startMIDDLELastSpecification;
use Basko\SpecificationTest\Value\PlayingCard;

class UtilsTest extends BaseTest
{
    public function testUtilsFlatten()
    {
        $this->assertEquals(
            [1, 2, 3, 4],
            Utils::flatten([1, 2, [3], [[4]]])
        );
    }

    public function specifications()
    {
        yield [new ClubsSpecification(), 'clubs'];
        yield [new TypedSpecification(new ClubsSpecification(), PlayingCard::class), 'clubs'];
        yield [new SomeHTMLSpecification(), 'some_html'];
        yield [new PDFLoadableSpecification(), 'pdf_loadable'];
        yield [new startMIDDLELastSpecification(), 'start_middle_last'];
        yield [new Some4Numbers234Specification(), 'some4_numbers234'];
    }

    /**
     * @dataProvider specifications
     */
    public function testSpecName($spec, $expectedSnakeCase)
    {
        $this->assertEquals($expectedSnakeCase, Utils::toSnakeCase($spec));
    }

    public function testSpecNameGroup()
    {
        $spec = new AndSpecification(new ClubsSpecification(), new SomeHTMLSpecification());
        $this->assertEquals(
            ['and' => ['clubs', 'some_html']],
            Utils::toSnakeCase($spec)
        );

        $spec2 = new AndSpecification(new PDFLoadableSpecification(), new startMIDDLELastSpecification());
        $this->assertEquals(
            ['and' => ['pdf_loadable', 'start_middle_last']],
            Utils::toSnakeCase($spec2)
        );

        $orSpec = new OrSpecification($spec, $spec2, new Some4Numbers234Specification());
        $this->assertEquals(
            [
                'or' => [
                    ['and' => ['clubs', 'some_html']],
                    ['and' => ['pdf_loadable', 'start_middle_last']],
                    'some4_numbers234',
                ],
            ],
            Utils::toSnakeCase($orSpec)
        );
    }
}