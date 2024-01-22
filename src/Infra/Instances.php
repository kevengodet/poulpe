<?php

declare(strict_types=1);

namespace Poulpe\Infra;

use Poulpe\Infra\Instance;

final class Instances
{
    private const DEFAULT = 'prod.mycompany.com';

    /** @var Instance[] */
    private array $instances;

    public function __construct(Instance ...$instances)
    {
        $this->instances = $instances;
    }

    public function default(): Instance
    {
        foreach ($this->instances as $instance) {
            if (self::DEFAULT === $instance->getDomainName()) {
                return $instance;
            }
        }

        throw new \LogicException(sprintf("No instance found for name '%s'.", self::DEFAULT));
    }
}
