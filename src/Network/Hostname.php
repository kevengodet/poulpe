<?php

declare(strict_types=1);

namespace Poulpe\Network;

final class Hostname
{
    private string $hostname;

    public function __construct(string $hostname)
    {
        if (false === filter_var($hostname, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            throw new \InvalidArgumentException("'$hostname' is not a valid host name.");
        }

        $this->hostname = $hostname;
    }

    public function isResolved(): bool
    {
        return gethostbyname($this->hostname) !== $this->hostname;
    }

    public function addToHosts(): void
    {
        (new \SplFileObject('/etc/hosts', 'a'))->fwrite($this->buildHostsLine());
    }

    private function buildHostsLine(): string
    {
        return "127.0.0.1\t{$this->hostname}\n";
    }
}
