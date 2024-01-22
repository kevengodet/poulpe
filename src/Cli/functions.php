<?php

declare(strict_types=1);

namespace Poulpe\Cli;

/**
 * Return the value of $a_variable, if set, or try to retrieve it from environment variable $ENV_VAR_NAME
 */
function get_or_env($a_variable, string $ENV_VAR_NAME, bool $allowNullValue = false)
{
    $value = $a_variable ?? getenv($ENV_VAR_NAME);

    if (is_null($value) && !$allowNullValue) {
        throw new \UnexpectedValueException("Provide a value or set $ENV_VAR_NAME environment variable.");
    }

    return $value;
}
