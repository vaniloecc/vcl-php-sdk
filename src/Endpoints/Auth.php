<?php

declare(strict_types=1);

/**
 * Contains the Auth trait.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-18
 *
 */

namespace VaniloCloud\Endpoints;

use VaniloCloud\Exceptions\AccessForbiddenException;
use VaniloCloud\Exceptions\InvalidCredentialsException;
use VaniloCloud\Exceptions\InvalidEndpointException;
use VaniloCloud\Exceptions\InvalidRefreshTokenException;
use VaniloCloud\Exceptions\RefreshTokenExpiredException;
use VaniloCloud\Models\Credentials;
use VaniloCloud\Models\Token;

trait Auth
{
    /**
     * @throws InvalidCredentialsException
     * @throws InvalidEndpointException
     */
    public function authLogin(Credentials $credentials): Token
    {
        $result = $this->http->asForm()->post($this->url . '/auth/login', $credentials->toArray());

        if (401 === $result->status()) {
            throw new InvalidCredentialsException($result->json('message', 'Invalid Credentials'));
        } elseif (422 === $result->status()) {
            throw new InvalidCredentialsException($result->json('message', 'Malformed Credentials'));
        } elseif (404 === $result->status()) {
            throw new InvalidEndpointException("The remote URL `{$this->url}` is not a Vanilo Cloud API");
        }

        return new Token(
            $result->json('access_token'),
            $result->json('expires_in'),
            $result->json('refresh_token'),
        );
    }

    /**
     * @throws RefreshTokenExpiredException
     * @throws InvalidRefreshTokenException
     * @throws AccessForbiddenException
     * @throws InvalidEndpointException
     */
    public function authToken(string $refreshToken): Token
    {
        $result = $this->http->asForm()->post($this->url . '/auth/login', ['refresh_token' => $refreshToken]);

        if (400 === $result->status()) {
            throw new InvalidRefreshTokenException($result->json('message', 'The passed token is not a refresh token'));
        } elseif (401 === $result->status()) {
            throw new RefreshTokenExpiredException($result->json('message', 'Refresh token has expired. Use the login endpoint to get a new one.'));
        } elseif (403 === $result->status()) {
            throw new AccessForbiddenException($result->json('message', 'Your access is forbidden. Your account is probably disabled'));
        } elseif (404 === $result->status()) {
            throw new InvalidEndpointException("The remote URL `{$this->url}` is not a Vanilo Cloud API");
        }

        return new Token(
            $result->json('access_token'),
            $result->json('expires_in'),
            $result->json('refresh_token'),
        );
    }
}
