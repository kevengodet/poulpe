<?php

declare(strict_types=1);

namespace Poulpe\Infra;

final class InstanceCache
{
    private string $cacheDir;

    public function __construct(string $cacheDir)
    {
        $this->cacheDir = rtrim($cacheDir, '/');

        if (!file_exists($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    public function cache(Instance ...$instances): void
    {
        file_put_contents($this->getCacheFilePath(), $this->generatePhp(...$instances));
    }

    /** @return Instance[] */
    public function read(): array
    {
        return require_once $this->getCacheFilePath();
    }

    private function getCacheFilePath(): string
    {
        return $this->cacheDir.'/instances.php';
    }

    private function generatePhp(Instance ...$instances): string
    {
        $php = '<?php'.PHP_EOL.'return ['.PHP_EOL;
        foreach ($instances as $instance) {
            $php .= 'Instance::fromArray(';
            $php .= var_export($instance->toArray(), true).PHP_EOL;
            $php .= '),'.PHP_EOL;
        }
        $php .= '];';

        return $php;
    }
}
