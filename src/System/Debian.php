<?php

declare(strict_types=1);

namespace Poulpe\System;

use Symfony\Component\Process\Process;

final class Debian
{
    public function install(Package $package) : Process
    {
        $process = new Process($this->getInstallCommand($package));
        $process->run();

        return $process;
    }

    public function getInstallCommand(Package $package): array
    {
        return ['sudo', 'apt', 'install', '-y', '--no-install-suggests', $package->getName()];
    }
}
