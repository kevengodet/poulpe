<?php

declare(strict_types=1);

namespace Poulpe\VersionControl;

final class Branch
{
    private string $branchName;

    public function __construct(string $branchName)
    {
        $this->branchName = $branchName;
    }

    public static function current(): Branch
    {
        $branchName = system('git rev-parse --abbrev-ref HEAD');

        return new self($branchName);
    }

    public function getName(): string
    {
        return $this->branchName;
    }

    public function __toString(): string
    {
        return $this->branchName;
    }
}
