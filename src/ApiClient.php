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

final class ApiClient
{
    use Endpoints\Taxonomies;

    private const SANDBOX_URL = 'https://sandbox.v-shop.cloud/';

    private HttpClient $http;

    private DateTimeZone $timezone;

    private string $url;

    private array $credentials = [];

    public function __construct(string $url)
    {
        $this->url = Str::finish($url, '/') . 'api/1.0';
        $this->timezone = new DateTimeZone('UTC');
        $this->http = new HttpClient();
    }

    public static function for(string $url): ApiClient
    {
        return new self($url);
    }

    public static function sandbox(): ApiClient
    {
        return self::for(self::SANDBOX_URL)->withAuthToken('');
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
        $this->credentials['auth_token'] = $token;

        return $this;
    }

    private function get(string $path): Response
    {
        return $this
            ->http
            ->withToken($this->credentials['auth_token'])
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
}
