<?php

declare(strict_types=1);

namespace Poulpe\File;

use Poulpe\File\TextFile;

final class HostFile
{
    private TextFile $file;

    public function __construct(string $path = '/etc/hosts')
    {
        $this->file = new TextFile($path);
    }

    public function add(string $host, string $ip = '127.0.0.1'): self
    {
        $this->file
            ->after('# For prod', true)
            ->insert("$ip\t$host")
        ;

        return $this;
    }

    public function save(): self
    {
        $this->file->save();

        return $this;
    }
}
