<?php

declare(strict_types=1);

/**
 * Contains the ApiClient class.
 *
 * @copyright   Copyright (c) 2023 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-13
 *
 */

namespace VaniloCloud;

use Illuminate\Http\Client\Factory as HttpClient;

final class ApiClient
{
    private HttpClient $http;

    private array $credentials = [];

    public function __construct(
        private string $url
    ) {
        $this->http = new HttpClient();
    }

    public static function connectTo(string $url): ApiClient
    {
        return new self($url);
    }

    public function withCredentials(string $clientId, string $clientSecret): ApiClient
    {
        $this->credentials['client_id'] = $clientId;
        $this->credentials['client_secret'] = $clientSecret;

        return $this;
    }

    public function withRefreshToken(string $token): ApiClient
    {
        $this->credentials['refresh_token'] = $token;

        return $this;
    }

    public function withAuthToken(string $token): ApiClient
    {
        $this->credentials['auth_token'] = $token;

        return $this;
    }
}
