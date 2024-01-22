<?php

declare(strict_types=1);

namespace Poulpe\CI;

use JenkinsKhan\Jenkins as JenkinsClient;
use Poulpe\CI\Job;
use Poulpe\Infra\Instance;
use Poulpe\VersionControl\Branch;
use function Poulpe\Cli\get_or_env;

final class Jenkins
{
    private JenkinsClient $client;

    public function __construct(JenkinsClient $client)
    {
        $this->client = $client;
    }

    public static function create(string $username = null, string $apiKey = null, string $baseUri = 'https://jenkins.mycompany.com'): self
    {
        $uri = parse_url(get_or_env($baseUri, 'JENKINS_URL'));

        // Insert <username>:<api_key> auth in Jenkins server URI string
        return new self(new JenkinsClient(
            $uri['scheme'].
            urlencode(get_or_env($username, 'JENKINS_USER_ID')) . ':' .
            urlencode(get_or_env($apiKey, 'JENKINS_API_TOKEN')) .
            $uri['host'] .
            isset($uri['port']) ? ':' . $uri['port'] : '')
        );
    }

    public function fork(Branch $branch = null, Instance $instance = null): Job
    {
        $branch ??= Branch::current();
        $instance ??=
    }
}
