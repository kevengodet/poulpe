<?php

declare(strict_types=1);

namespace Poulpe\Infra;

use Poulpe\Infra\Instance;

final class InstanceLoader
{
    /**
     * @param string $jsonPath
     * @return Instance[]
     * @throws \ReflectionException
     */
    public function loadFromJson(string $jsonPath): array
    {
        return array_map(fn($a) => Instance::fromArray($a), json_decode(file_get_contents($jsonPath), true));
    }
}
