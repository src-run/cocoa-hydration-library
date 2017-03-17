<?php

/*
 * This file is part of the `src-run/cocoa-hydration-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Hydration;

use SR\Cocoa\Hydration\Exception\InvalidArgumentException;

class Extractor
{
    /**
     * @var int
     */
    const MASK_PUBLIC = \ReflectionProperty::IS_PUBLIC;

    /**
     * @var int
     */
    const MASK_PROTECTED = \ReflectionProperty::IS_PROTECTED;

    /**
     * @var int
     */
    const MASK_PRIVATE = \ReflectionProperty::IS_PRIVATE;

    /**
     * @var object
     */
    private $object;

    /**
     * @var int
     */
    private $mask = self::MASK_PUBLIC | self::MASK_PROTECTED | self::MASK_PRIVATE;

    /**
     * @param int $mask
     *
     * @return $this
     */
    public function setMask($mask)
    {
        $this->mask = $mask;

        return $this;
    }

    /**
     * @param object $object
     *
     * @return $this
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * @param object|null $object
     *
     * @return mixed[]
     */
    public function extract($object = null)
    {
        if (null !== $object) {
            $this->setObject($object);
        }

        return $this->getProperties($this->getReflectionObject());
    }

    /**
     * @throws InvalidArgumentException If reflection object cannot be created
     *
     * @return \ReflectionObject
     */
    private function getReflectionObject()
    {
        try {
            return new \ReflectionObject($this->object);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Extract method expects object instance (got %s="%s")', gettype($this->object), var_export($this->object, true));
        }
    }

    /**
     * @param \ReflectionObject $object
     *
     * @return array
     */
    private function getProperties(\ReflectionObject $object)
    {
        $reflection = $object->getProperties($this->mask);
        $valueProps = array_map([$this, 'resolvePropertyValue'], $reflection);
        $namedProps = array_map(function (\ReflectionProperty $property) {
            return $property->getName();
        }, $reflection);

        return array_combine($namedProps, $valueProps);
    }

    /**
     * @param \ReflectionProperty $property
     *
     * @return mixed
     */
    private function resolvePropertyValue(\ReflectionProperty $property)
    {
        if ($property->isPrivate() || $property->isProtected()) {
            $property->setAccessible(true);
        }

        if ($property->isStatic()) {
            return $property->getValue();
        }

        return $property->getValue($this->object);
    }
}
