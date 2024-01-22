<?php

declare(strict_types=1);

namespace Poulpe\Traits;

use Poulpe\Traits\Arrayable;

trait JsonSerializable
{
    use Arrayable;

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
