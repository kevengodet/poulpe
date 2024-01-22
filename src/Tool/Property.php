<?php

declare(strict_types=1);

namespace Poulpe\Tool;

use Poulpe\Tool\Type;

final class Property
{
    private string $name;

    private Type $type;

    /**
     * @param string $name
     * @param Type $type
     */
    public function __construct(string $name, Type $type)
    {
        $this->name = $name;
        $this->type = $type;
    }
}
