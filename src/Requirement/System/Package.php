<?php

declare(strict_types=1);

namespace Poulpe\System;

use Poulpe\RequirementInterface;

final class Package implements RequirementInterface
{
    private string $name;
    private ?Version $version;

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): ?Version
    {
        return $this->version;
    }
}
