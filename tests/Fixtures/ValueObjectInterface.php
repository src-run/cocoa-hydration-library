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

interface ValueObjectInterface
{
    public function getExpectedExtractionData();
    public function getExpectedExtractionPublicData();
    public function getExpectedExtractionProtectedData();
    public function getExpectedExtractionPrivateData();
    public function getExpectedExtractionPrivateStaticData();
}