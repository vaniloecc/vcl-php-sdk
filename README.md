# Vanilo Cloud PHP SDK

[![Tests](https://img.shields.io/github/actions/workflow/status/vaniloecc/vcl-php-sdk/tests.yml?branch=master&style=flat-square)](https://github.com/vaniloecc/vcl-php-sdk/actions?query=workflow%3Atests)
[![Packagist version](https://img.shields.io/packagist/v/vanilo/cloud-sdk.svg?style=flat-square)](https://packagist.org/packages/vanilo/cloud-sdk)
[![Packagist downloads](https://img.shields.io/packagist/dt/vanilo/cloud-sdk.svg?style=flat-square)](https://packagist.org/packages/vanilo/cloud-sdk)
[![StyleCI](https://styleci.io/repos/588679104/shield?branch=master)](https://styleci.io/repos/588679104)
[![MIT Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

This package provides a PHP SDK for interacting with the [Vanilo Cloud REST API](https://vanilo.cloud/docs/api/).

## Installation

> The minimum requirement of this package is PHP 8.1.

To install this library in your application, use composer:

```bash
composer require vanilo/cloud-sdk
```

## Usage

### Authentication

To connect to the Vanilo Cloud API, you'll need your Shop's URL, a `client_id` and a `client_secret`.

The following code returns an API client instance:

```php
$api = VaniloCloud\ApiClient::for('https://your.v-shop.cloud')->withCredentials('client id', 'client secret');
```

> Under the hood, the SDK will fetch auth tokens from the API in order to
> minimize the number of occasions when the `client_id` and `client_secret` are
> being sent over the wire.

To connect to the generic Sandbox environment use:

```php
$api = VaniloCloud\ApiClient::sandbox();
```

> Vanilo Cloud Sandbox is available at: https://sandbox.v-shop.cloud/  
> The sandbox database is reset every 30 minutes

### Retrieve Raw Responses

If you need to obtain the raw HTTP response from the API, you need to call the `rawGet`, `rawPost`, etc methods:

```php
$api = VaniloCloud\ApiClient::sandbox();
$api->rawGet('/taxonomies');
//=> Illuminate\Http\Client\Response {#2743
//     +cookies: GuzzleHttp\Cookie\CookieJar {#2725},
//     +transferStats: GuzzleHttp\TransferStats {#2765},
```

To obtain the contents of the API call, use `json()` method of the returned response:

```php
$response = $api->rawGet('/taxonomies');
foreach ($response->json('data') as $taxonomy) {
    echo $taxonomy['name'];
}
// Category
```

### Taxonomies

To fetch a taxonomy by id:

```php
$api = VaniloCloud\ApiClient::sandbox();
$taxonomy = $api->taxonomy(1);
// => VaniloCloud\Models\Taxonomy
//     id: "1",
//     name: "Category",
//     slug: "category",
//     created_at: "2022-12-06T16:23:34+00:00",
//     updated_at: "2023-01-13T08:03:29+00:00"
```

### Products
