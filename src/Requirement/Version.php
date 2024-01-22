<?php

declare(strict_types=1);

namespace Poulpe\Requirement;

final class Version
{
    public const
        OP_AROUND = '~',
        OP_AT_LEAST = '>',
        OP_AT_LEAST_OR_EQUAL = '>=',
        OP_MAJOR = '^'
    ;
    private const OPS = [
        self::OP_AROUND,
        self::OP_MAJOR,

        // Keep this order!
        self::OP_AT_LEAST_OR_EQUAL,
        self::OP_AT_LEAST,
    ];

    private string $operator;
    private string $version;

    public function __construct(string $version) {
        foreach (self::OPS as $op) {
            if (str_starts_with($version, $op)) {
                $this->operator = $op;
                $this->version = $version;

                return;
            }
        }

        $this->version = $version;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getVersion(): string
    {
        return $this->version;
    }
}
