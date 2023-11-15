<?php

declare(strict_types=1);

/**
 * Contains the LaravelTokenStoreTest class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-11-15
 *
 */

namespace VaniloCloud\Tests\Laravel;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use VaniloCloud\ApiClient;

class LaravelTokenStoreTest extends TestCase
{
    /** @test */
    public function it_can_use_the_token_driver()
    {
        $api = ApiClient::sandbox()->useLaravelTokenStore();
        $taxonomyId = $api->createTaxonomy(Str::ulid()->toBase58());
        $this->assertNotNull($taxonomyId);

        $this->assertTrue($api->deleteTaxonomy($taxonomyId));
    }

    /** @test */
    public function it_can_get_a_new_access_token_after_it_expires_using_the_refresh_token()
    {
        Cache::clear();
        $api = ApiClient::sandbox()->useLaravelTokenStore(2);
        $taxonomyId = $api->createTaxonomy(Str::uuid()->toString());
        $this->assertNotNull($taxonomyId);

        sleep(2);

        $this->assertTrue($api->deleteTaxonomy($taxonomyId));
    }

    protected function defineEnvironment($app)
    {
        // Setup default database to use sqlite :memory:
        tap($app['config'], function ($config) {
            $config->set('cache.default', 'file');
        });
    }
}
