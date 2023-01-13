<?php

declare(strict_types=1);

/**
 * Contains the ApiClientTest class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-13
 *
 */

namespace VaniloCloud\Tests;

use PHPUnit\Framework\TestCase;
use VaniloCloud\ApiClient;

class ApiClientTest extends TestCase
{
    /** @test */
    public function the_time_zone_is_europe_bucharest_by_default()
    {
        $api = ApiClient::sandbox();
        $this->assertEquals('UTC', $api->timezone()->getName());
    }

    /** @test */
    public function the_timezone_can_be_changed()
    {
        $api = ApiClient::sandbox();
        $api->useTimeZone('Europe/Berlin');
        $this->assertEquals('Europe/Berlin', $api->timezone()->getName());
    }
}
