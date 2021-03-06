<?php

declare(strict_types=1);

/**
 * This file is part of the JobRouter Client.
 *
 * Copyright (c) 2019-2021 Chris Müller
 *
 * For the full copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 *
 * @see https://github.com/brotkrueml/jobrouter-client
 */

namespace Brotkrueml\JobRouterClient\Client;

use Brotkrueml\JobRouterClient\Configuration\ClientConfiguration;

final class ClientFactory
{
    private function __construct()
    {
        // Class must not be instantiated!
    }

    public static function createRestClient(
        string $baseUrl,
        string $username,
        string $password,
        int $lifetime = ClientConfiguration::DEFAULT_TOKEN_LIFETIME_IN_SECONDS
    ): RestClient {
        $configuration = new ClientConfiguration($baseUrl, $username, $password);
        if (ClientConfiguration::DEFAULT_TOKEN_LIFETIME_IN_SECONDS !== $lifetime) {
            $configuration = $configuration->withLifetime($lifetime);
        }

        return new RestClient($configuration);
    }

    public static function createIncidentsClientDecorator(
        string $baseUrl,
        string $username,
        string $password,
        int $lifetime = ClientConfiguration::DEFAULT_TOKEN_LIFETIME_IN_SECONDS
    ): IncidentsClientDecorator {
        return new IncidentsClientDecorator(static::createRestClient($baseUrl, $username, $password, $lifetime));
    }

    public static function createDocumentsClientDecorator(
        string $baseUrl,
        string $username,
        string $password,
        int $lifetime = ClientConfiguration::DEFAULT_TOKEN_LIFETIME_IN_SECONDS
    ): DocumentsClientDecorator {
        return new DocumentsClientDecorator(static::createRestClient($baseUrl, $username, $password, $lifetime));
    }
}
