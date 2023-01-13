# Vanilo Cloud PHP SDK
---

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

> Under the hood, the SDK will fetch auth tokens from the API in order to
> minimize the number of occasions when the `client_id` and `client_secret` are
> being sent over the wire.

#### Connecting To The API

```php
$cloudApi = VaniloCloud\ApiClient::for('https://your.v-shop.cloud')->withCredentials('client id', 'client secret');
```
