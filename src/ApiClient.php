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
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionNamedType;
use VaniloCloud\Attributes\ArrayOf;
use VaniloCloud\Contracts\TokenStore;
use VaniloCloud\Exceptions\MissingCredentialsException;
use VaniloCloud\Models\Credentials;
use VaniloCloud\Stores\ApcTokenStore;
use VaniloCloud\Stores\LaravelCacheTokenStore;
use VaniloCloud\Stores\MemoryTokenStore;

final class ApiClient
{
    use Endpoints\Taxonomies;
    use Endpoints\Auth;
    use Endpoints\Products;
    use Endpoints\MasterProducts;
    use Endpoints\Orders;
    use Endpoints\Customers;
    use Endpoints\Addresses;

    public const VERSION = '0.8.0';

    private const SANDBOX_URL = 'https://sandbox.v-shop.cloud/';
    private const SANDBOX_CLIENT_ID = 'test+api@sandbox.v-shop.cloud';
    private const SANDBOX_CLIENT_SECRET = 'jINdGbop8NwA6bGZcQBMtAVIDLuezI8yDaYweq4p07';

    private HttpClient $http;

    private DateTimeZone $timezone;

    private string $url;

    private string $userAgent;

    private array $credentials = [];

    private ?string $basicAuthUser = null;

    private ?string $basicAuthPass = null;

    private ?TokenStore $tokenStore;

    public function __construct(string $url, TokenStore $tokenStore = null)
    {
        $this->url = Str::finish($url, '/') . 'api/1.0';
        $this->timezone = new DateTimeZone('UTC');
        $this->tokenStore = $tokenStore;
        $this->userAgent = sprintf('Vanilo Cloud SDK (PHP %s; %s; %s; v%s)', phpversion(), php_uname('s'), php_uname('m'), self::VERSION);
        $this->http = new HttpClient();
    }

    public static function for(string $url): ApiClient
    {
        return new self($url);
    }

    public static function sandbox(TokenStore $tokenStore = null): ApiClient
    {
        $instance = self::for(self::SANDBOX_URL);

        if (null !== $tokenStore) {
            $instance->usingTokenStore($tokenStore);
        }

        return $instance->withCredentials(self::SANDBOX_CLIENT_ID, self::SANDBOX_CLIENT_SECRET);
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

    public function withBasicAuth(string $user, string $password): ApiClient
    {
        $this->basicAuthUser = $user;
        $this->basicAuthPass = $password;

        return $this;
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

    public function usingTokenStore(TokenStore $tokenStore): ApiClient
    {
        $this->tokenStore = $tokenStore;

        return $this;
    }

    public function useLaravelTokenStore(int $accessTokenTtl = 90000, int $refreshTokenTtl = 31708800): ApiClient
    {
        return $this->usingTokenStore(new LaravelCacheTokenStore($this->url, null, $accessTokenTtl, $refreshTokenTtl));
    }

    public function currentTokenStore(): string
    {
        if (null === $this->tokenStore) {
            return 'none';
        }

        return match ($this->tokenStore::class) {
            MemoryTokenStore::class => 'memory',
            ApcTokenStore::class => 'apc',
            LaravelCacheTokenStore::class => 'laravel',
            default => $this->tokenStore::class,
        };
    }

    public function rawGet(string $path, null|array|string $query = null): Response
    {
        return $this->get($path, $query);
    }

    public function rawPost(string $path, array $payload): Response
    {
        return $this->post($path, $payload);
    }

    public function rawPatch(string $path, array $payload): Response
    {
        return $this->patch($path, $payload);
    }

    public function rawDelete(string $path): Response
    {
        return $this->delete($path);
    }

    private function get(string $path, null|array|string $query = null): Response
    {
        return $this
            ->baseHttpClient()
            ->get($this->url . $path, $query);
    }

    private function post(string $path, array $payload): Response
    {
        return $this
            ->baseHttpClient()
            ->post($this->url . $path, $payload);
    }

    private function patch(string $path, array $payload): Response
    {
        return $this
            ->baseHttpClient()
            ->patch($this->url . $path, $payload);
    }

    private function delete(string $path): Response
    {
        return $this
            ->baseHttpClient()
            ->delete($this->url . $path);
    }

    private function transpose(array $attributes, string $forClass): array
    {
        $result = [];

        foreach ($attributes as $key => $value) {
            if ($this->isABoolProperty($key, $forClass)) {
                $actualValue = is_string($value) ? ('true' === strtolower($value)) : $value;
            } elseif ($this->isADateTimeProperty($key, $forClass)) {
                $actualValue = null !== $value ? $this->makeDateTime($value) : null;
            } elseif ($this->isAnEnumProperty($key, $forClass)) {
                $actualValue = $this->makeEnum($key, $forClass, $value);
            } elseif ($this->isAnObjectProperty($key, $forClass)) {
                $actualValue = $this->makeObject($key, $forClass, $value);
            } elseif($this->isAnArrayOfObjectsProperty($key, $forClass)) {
                $actualValue = $this->makeAnArrayOfObjectsProperty($key, $forClass, $value);
            }
            else {
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

    private function isAnEnumProperty(string $property, string $class): bool
    {
        if (!property_exists($class, $property)) {
            return false;
        }

        $details = new \ReflectionProperty($class, $property);
        $type = $details->getType();

        if ($type instanceof ReflectionNamedType) {
            $typeName = $type->getName();

            if (class_exists($typeName)) {
                return (new \ReflectionClass($typeName))->implementsInterface(\UnitEnum::class);
            }
        }

        return false;
    }

    private function isAnObjectProperty(string $property, string $class): bool
    {
        if (!property_exists($class, $property)) {
            return false;
        }

        $details = new \ReflectionProperty($class, $property);
        $type = $details->getType();

        if ($type instanceof ReflectionNamedType) {
            $typeName = $type->getName();

            return class_exists($typeName);
        }

        return false;
    }

    private function isAnArrayOfObjectsProperty(string $property, string $class): bool
    {
        if (!property_exists($class, $property)) {
            return false;
        }

        $reflectionProperty = new \ReflectionProperty($class, $property);
        $type = $reflectionProperty->getType();

        if (!($type instanceof \ReflectionNamedType) || $type->getName() !== 'array') {
            return false;
        }

        $attributes = $reflectionProperty->getAttributes(ArrayOf::class);

        return !empty($attributes);
    }

    private function makeEnum(string $property, string $class, string $value): \UnitEnum|null
    {
        $details = new \ReflectionProperty($class, $property);

        $type = $details->getType();

        if (!($type instanceof ReflectionNamedType)) {
            return null;
        }

        $typeName = $type->getName();

        return $typeName::tryFrom($value);
    }

    private function makeObject(string $property, string $class, ?array $value): object|null
    {
        if (null === $value) {
            return null;
        }

        $details = new \ReflectionProperty($class, $property);

        $type = $details->getType();

        if (!($type instanceof ReflectionNamedType)) {
            return null;
        }

        $typeName = $type->getName();

        if (!class_exists($typeName)) {
            return null;
        }

        return new $typeName($this->transpose($value, $typeName));
    }

    private function makeAnArrayOfObjectsProperty(string $property, string $class, ?array $value): array|null
    {
        if (null === $value) {
            return null;
        }

        $reflectionProperty = new \ReflectionProperty($class, $property);
        $attributes = $reflectionProperty->getAttributes(ArrayOf::class);

        $arrayOfType = $attributes[0]->newInstance()->type;

        if (!class_exists($arrayOfType)) {
            return null;
        }

        return array_map(fn($item) => new $arrayOfType($this->transpose($item, $arrayOfType)), $value);
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
            if (extension_loaded('apcu') && apcu_enabled()) {
                $this->tokenStore = new ApcTokenStore($this->url);
            } else {
                $this->tokenStore = new MemoryTokenStore();
            }
        }

        return $this->tokenStore;
    }

    private function baseHttpClient(): PendingRequest
    {
        $result = $this
            ->http
            ->withoutRedirecting()
            ->withUserAgent($this->userAgent)
            ->withToken($this->wangleAuthToken())
            ->acceptJson()
            ->asJson();

        return null !== $this->basicAuthUser ? $result->withBasicAuth($this->basicAuthUser, $this->basicAuthPass) : $result;
    }
}
