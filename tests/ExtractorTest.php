<?php

/*
 * This file is part of the `src-run/cocoa-hydration-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Hydration\Tests;

use SR\Cocoa\Hydration\Extractor;
use SR\Cocoa\Hydration\Tests\Fixtures\ValueObject;
use SR\Cocoa\Hydration\Tests\Fixtures\ValueObjectInterface;

class ExtractorText extends \PHPUnit_Framework_TestCase
{
    /**
     * @return mixed[]
     */
    public static function provideInvalidArgumentData()
    {
        return [
            ['string'],
            [123],
            [true],
        ];
    }

    /**
     * @dataProvider provideInvalidArgumentData
     *
     * @expectedException \SR\Cocoa\Hydration\Exception\InvalidArgumentException
     * @expectedExceptionMessageRegExp {Extract method expects object instance \(got (string|integer|boolean)=".+"\)}
     */
    public function testThrowsOnInvalidArgument($argument)
    {
        (new Extractor())->extract($argument);
    }

    /**
     * @return object[]
     */
    public static function provideValueObjectData()
    {
        return [
            [new ValueObject()],
        ];
    }

    /**
     * @dataProvider provideValueObjectData
     *
     * @param ValueObjectInterface $object
     */
    public function testExtraction(ValueObjectInterface $object)
    {
        $this->assertSame($object->getExpectedExtractionData(), (new Extractor())->extract($object));

        $e = new Extractor();
        $e->setMask(Extractor::MASK_PUBLIC);
        $this->assertSame($object->getExpectedExtractionPublicData(), $e->extract($object));

        $e = new Extractor();
        $e->setMask(Extractor::MASK_PROTECTED);
        $this->assertSame($object->getExpectedExtractionProtectedData(), $e->extract($object));

        $e = new Extractor();
        $e->setMask(Extractor::MASK_PRIVATE);
        $expected = array_merge($object->getExpectedExtractionPrivateData(), $object->getExpectedExtractionPrivateStaticData());
        $this->assertSame($expected, $e->extract($object));
    }
}