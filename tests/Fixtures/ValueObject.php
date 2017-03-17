<?php

/*
 * This file is part of the `src-run/cocoa-hydration-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Hydration\Tests\Fixtures;

class ValueObject implements ValueObjectInterface
{
    public $publicFoo = 'foo';
    public $publicBar = 'bar';
    protected $protectedFoo = 'foo';
    protected $protectedBar = 'bar';
    private $privateFoo = 'foo';
    private $privateBar = 'bar';
    static private $staticPrivateFoo = 'foo';
    static private $staticPrivateBar = 'bar';

    public function getExpectedExtractionData()
    {
        return array_merge(
            $this->getExpectedExtractionPublicData(),
            $this->getExpectedExtractionProtectedData(),
            $this->getExpectedExtractionPrivateData(),
            $this->getExpectedExtractionPrivateStaticData()
        );
    }

    public function getExpectedExtractionPublicData()
    {
        return [
            'publicFoo' => $this->publicFoo,
            'publicBar' => $this->publicBar,
        ];
    }

    public function getExpectedExtractionProtectedData()
    {
        return [
            'protectedFoo' => $this->protectedFoo,
            'protectedBar' => $this->protectedBar,
        ];
    }

    public function getExpectedExtractionPrivateData()
    {
        return [
            'privateFoo' => $this->privateFoo,
            'privateBar' => $this->privateBar,
        ];
    }

    public function getExpectedExtractionPrivateStaticData()
    {
        return [
            'staticPrivateFoo' => static::$staticPrivateFoo,
            'staticPrivateBar' => static::$staticPrivateBar,
        ];
    }
}