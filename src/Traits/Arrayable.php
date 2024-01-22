<?php

declare(strict_types=1);

namespace Poulpe\Traits;

use Poulpe\Tool\Type;

trait Arrayable
{
    public function toArray(): array
    {
        $data = [];

        foreach (get_object_vars($this) as $name => $value) {
            $data[$name] = json_encode($value);
        }

        return $data;
    }

    /**
     * @throws \ReflectionException
     */
    public static function fromArray(array $data): self
    {
        $obj = (new \ReflectionClass(self::class))->newInstanceWithoutConstructor();
        foreach ($data as $name => $value) {
            try {
                $property = new \ReflectionProperty(self::class, $name);
                $obj->$name = (new Type($property->getType()))->cast($value);
            } catch (\ReflectionException $e) {
                // Property does noe exist, go on...
            }
        }

        return $obj;
    }
}
