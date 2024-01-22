<?php

declare(strict_types=1);

use Poulpe\CI\Jenkins;

require_once dirname(__DIR__).'/vendor/autoload.php';

$jenkins = Jenkins::create();
print_r(getenv());
