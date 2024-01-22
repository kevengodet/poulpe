<?php

declare(strict_types=1);

namespace Poulpe\Tool;

final class Type
{
    public const
        NULL      = 'NULL',
        BOOL      = 'bool',
        INT       = 'int',
        FLOAT     = 'float',
        ARRAY     = 'array',
        OBJECT    = 'object',
        ITERABLE  = 'iterable',
        CALLABLE  = 'callable',
        STRING    = 'string',
        MIXED     = 'mixed',
        CLASS     = 'class'
    ;

    private string $name, $className;

    public function __construct(string $name, string $className = null)
    {
        $this->name      = $name;
        $this->className = $className;
    }

    public static function create($var): Type
    {
        switch ($typeName = gettype($var)) {
            case self::NULL:
            case self::BOOL:
            case self::INT:
            case self::FLOAT:
            case self::ARRAY:
            case self::STRING:
            case self::ITERABLE:
            case self::CALLABLE:
            case self::MIXED:
                return new self($typeName); break;
            case self::OBJECT:
                $className = get_class($var);
                if (\stdClass::class === $className) {
                    return new self(self::OBJECT);
                }

                return new self(self::CLASS, $className);

        }

        throw new \LogicException("'$typeName' is unknown.");
    }

    public static function fromReflection(\ReflectionProperty $r): self
    {
        return new self($r->getName(), $r->getType()->getName());
    }

    public function isScalar(): bool
    {
        return in_array($this->name, [self::NULL, self::INT, self::FLOAT, self::STRING, self::BOOL]);
    }

    /**
     * Convert $value to the Type
     *
     * @param mixed $value
     * @return mixed
     */
    public function cast($value)
    {
        switch ($this->name) {
            case self::BOOL:     return (bool) $value;
            case self::FLOAT:    return (float) $value;
            case self::INT:      return (int) $value;
            case self::STRING:   return (string) $value;
            case self::ARRAY:    return is_array($value) ? $value : (is_iterable($value) ? iterator_to_array($value) : [$value]);
            case self::ITERABLE: return is_iterable($value) ? $value : [$value];
            case self::OBJECT:   return is_object($value) ? $value : (object) $value;
            case self::CALLABLE: throw new \LogicException('Not supported yet');
            case self::CLASS:    throw new \LogicException('Not supported yet');
            case self::MIXED:
            default:             return $value;

        }
    }
}
