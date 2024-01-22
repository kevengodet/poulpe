<?php

declare(strict_types=1);

namespace Poulpe;

interface RequirementInterface
{
    public function isFulfilled(): bool;
    public function hint(): string;
    public function canFulfill(): bool;
    public function fulfill(): void;
}
