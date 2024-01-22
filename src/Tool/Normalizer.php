<?php

declare(strict_types=1);

namespace Poulpe\Tool;

final class Normalizer
{
    /**
     * Normalize data:
     *
     *   int    -> int
     *   float  -> float
     *   string -> string
     *   bool   -> bool
     *   array  -> array of normalize(item)
     *   object -> array of normalize(properties)
     */
    public function normalize($var)
    {
        switch (gettype($var)) {
            case Type::NULL:
            case Type::BOOL:
            case Type::INT:
            case Type::ITERABLE:
            case Type::STRING:
                return $var;
            case Type::ARRAY:
                return array_map(fn($v) => $this->normalize($v), $var);
            case Type::OBJECT;
                if ($var instanceof \DateTimeInterface) {
                    return $var->format(DATE_ATOM);
                }

                return array_map(fn($v) => $this->normalize($v), get_object_vars($var));
            default:
                throw new \RuntimeException(sprintf("Cannot normalize data of type '%s'.", gettype($var)));
        }
    }

    public function denormalize($var, Type $targetType = null)
    {
        switch (gettype($var)) {
            case 'NULL':
            case 'bool':
            case 'int':
            case 'float':
            case 'string':
                return $var;
            case 'array':
                return array_map(fn($v) => $this->normalize($v), $var);
            case 'object';
                return array_map(fn($v) => $this->normalize($v), get_object_vars($var));
            default:
                throw new \RuntimeException(sprintf("Cannot denormalize data of type '%s'.", gettype($var)));
        }
    }
}
