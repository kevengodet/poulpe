<?php

declare(strict_types=1);

namespace Poulpe;

use Poulpe\Task\TaskInterface;

interface RunnerInterface
{
    public function run(TaskInterface $task): void;
}
