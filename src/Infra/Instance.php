<?php

declare(strict_types=1);

namespace Poulpe\Infra;

use Poulpe\Traits\JsonSerializable;

final class Instance implements \JsonSerializable
{
    use JsonSerializable;

    public const
        STATUS_ONLINE   = 0,
        STATUS_ARCHIVED = 1
    ;

    private string $client_name, $domain_name, $custom_styles, $custom_views, $db_username, $db_database, $logo, $mobile_app_type, $primary_color, $secondary_color, $google_maps_api_key, $gateway;
    private int $status, $grappe; // 0 = online, 1 = archived
    private array $supported_languages;

    public function getCustomerName(): string
    {
        return $this->client_name;
    }

    public function getDomainName(): string
    {
        return $this->domain_name;
    }

    public function getStatus(): int
    {
        return (int) $this->status;
    }

    public function isOnline(): bool
    {
        return self::STATUS_ONLINE === $this->getStatus();
    }
}
