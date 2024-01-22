<?php

declare(strict_types=1);

namespace Poulpe\Tool;

final class PropertyAccessor
{
    /** @var \ReflectionObject[] */
    private array $reflection;

    /**
     * @throws \ReflectionException
     */
    public function get(object $object, string $propertyName): Property
    {
        $id = spl_object_id($object);
        if (!isset($this->reflection[$id])) {
            $this->reflection[$id] = new \ReflectionObject($object);
        }

        if (!$this->reflection[$id]->hasProperty($propertyName)) {
            throw new \LogicException("Property '$propertyName' not found.");
        }

        return new Property($propertyName, Type::fromReflection($this->reflection[$id]->getProperty($propertyName)));
    }
}
