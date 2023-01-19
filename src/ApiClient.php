<?php

declare(strict_types=1);

/**
 * Contains the ApiClient class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-13
 *
 */

namespace VaniloCloud;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use DateTimeZone;
use Illuminate\Http\Client\Factory as HttpClient;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionNamedType;
use VaniloCloud\Contracts\TokenStore;
use VaniloCloud\Exceptions\MissingCredentialsException;
use VaniloCloud\Models\Credentials;
use VaniloCloud\Stores\MemoryTokenStore;

final class ApiClient
{
    use Endpoints\Taxonomies;
    use Endpoints\Auth;

    private const SANDBOX_URL = 'https://sandbox.v-shop.cloud/';
    private const SANDBOX_CLIENT_ID = 'test+api@sandbox.v-shop.cloud';
    private const SANDBOX_CLIENT_SECRET = 'jINdGbop8NwA6bGZcQBMtAVIDLuezI8yDaYweq4p07';

    private HttpClient $http;

    private DateTimeZone $timezone;

    private string $url;

    private array $credentials = [];

    private ?TokenStore $tokenStore;

    public function __construct(string $url, TokenStore $tokenStore = null)
    {
        $this->url = Str::finish($url, '/') . 'api/1.0';
        $this->timezone = new DateTimeZone('UTC');
        $this->tokenStore = $tokenStore;
        $this->http = new HttpClient();
    }

    public static function for(string $url): ApiClient
    {
        return new self($url);
    }

    public static function sandbox(): ApiClient
    {
        return self::for(self::SANDBOX_URL)->withCredentials(self::SANDBOX_CLIENT_ID, self::SANDBOX_CLIENT_SECRET);
    }

    public function useTimeZone(string $timeZone): self
    {
        $this->timezone = new DateTimeZone($timeZone);

        return $this;
    }

    public function timezone(): DateTimeZone
    {
        return $this->timezone;
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
        $this->credentials['access_token'] = $token;

        return $this;
    }

    public function usingTokenStore(TokenStore $tokenStore): void
    {
        $this->tokenStore = $tokenStore;
    }

    private function get(string $path): Response
    {
        return $this
            ->http
            ->withToken($this->wangleAuthToken())
            ->asJson()
            ->get($this->url . $path);
    }

    private function transpose(array $attributes, string $forClass): array
    {
        $result = [];

        foreach ($attributes as $key => $value) {
            if ($this->isABoolProperty($key, $forClass)) {
                $actualValue = 'true' === strtolower($value);
            } elseif ($this->isADateTimeProperty($key, $forClass)) {
                $actualValue = $this->makeDateTime($value);
            } else {
                $actualValue = $value;
            }

            $result[$key] = $actualValue;
        }

        return $result;
    }

    private function isABoolProperty(string $property, string $class): bool
    {
        if (!property_exists($class, $property)) {
            return false;
        }

        $details = new \ReflectionProperty($class, $property);

        if ($details->getType() instanceof ReflectionNamedType) {
            return 'bool' === $details->getType()->getName();
        }

        return !empty(Arr::where($details->getType()->getTypes(), fn ($type) => 'bool' === $type));
    }

    private function isADateTimeProperty(string $property, string $class): bool
    {
        if (!property_exists($class, $property)) {
            return false;
        }

        $dateTypes = [\DateTime::class, \DateTimeImmutable::class, Carbon::class, CarbonImmutable::class];
        $details = new \ReflectionProperty($class, $property);

        if ($details->getType() instanceof ReflectionNamedType) {
            return in_array($details->getType()->getName(), $dateTypes);
        }

        return !empty(Arr::where($details->getType()->getTypes(), fn ($type) => in_array($type, $dateTypes)));
    }

    private function makeDateTime(string $value): CarbonImmutable
    {
        return CarbonImmutable::parse($value)->setTimezone($this->timezone);
    }

    private function wangleAuthToken(): string
    {
        if (!isset($this->credentials['access_token'])) {
            $store = $this->tokenStore();
            if ($store->hasAccessToken()) {
                $this->credentials['access_token'] = $store->getAccessToken();
            } elseif (isset($this->credentials['refresh_token'])) {
                $token = $this->authToken($this->credentials['refresh_token']);
                $this->credentials['access_token'] = $token->accessToken;
                $store->saveAccessToken($token->accessToken);
            } elseif ($store->hasRefreshToken()) {
                $this->credentials['refresh_token'] = $store->getRefreshToken();
                $token = $this->authToken($this->credentials['refresh_token']);
                $this->credentials['access_token'] = $token->accessToken;
                $store->saveAccessToken($token->accessToken);
            } elseif (isset($this->credentials['client_id']) && isset($this->credentials['client_secret'])) {
                $token = $this->authLogin(Credentials::make($this->credentials));
                $this->credentials['refresh_token'] = $token->refreshToken;
                $this->credentials['access_token'] = $token->accessToken;
                $store->saveRefreshToken($token->refreshToken);
                $store->saveAccessToken($token->accessToken);
            } elseif ($store->hasCredentials()) {
                $token = $this->authLogin($store->getCredentials());
                $this->credentials['refresh_token'] = $token->refreshToken;
                $this->credentials['access_token'] = $token->accessToken;
                $store->saveRefreshToken($token->refreshToken);
                $store->saveAccessToken($token->accessToken);
            } else {
                throw new MissingCredentialsException('There are no credentials supplied, it\'s not possible to connect to the Vanilo Cloud API');
            }
        }

        return $this->credentials['access_token'];
    }

    private function tokenStore(): TokenStore
    {
        if (null === $this->tokenStore) {
            $this->tokenStore = new MemoryTokenStore();
        }

        return $this->tokenStore;
    }
}
