<?php

declare(strict_types=1);

/**
 * Contains the TaxonomiesTest class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-13
 *
 */

namespace VaniloCloud\Tests\Functional;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use VaniloCloud\ApiClient;
use VaniloCloud\Models\Taxonomy;
use VaniloCloud\Stores\ApcTokenStore;

class TaxonomiesTest extends TestCase
{
    /** @test */
    public function it_can_fetch_a_taxonomy_by_its_id()
    {
        $api = ApiClient::sandbox();

        $taxonomy = $api->taxonomy('1');
        $this->assertInstanceOf(Taxonomy::class, $taxonomy);
        $this->assertEquals('Category', $taxonomy->name);
        $this->assertEquals('category', $taxonomy->slug);
    }

    /** @test */
    public function it_can_retrieve_the_list_of_taxonomies()
    {
        $api = ApiClient::sandbox();

        $taxonomies = $api->taxonomies();

        $this->assertInstanceOf(Collection::class, $taxonomies);
        $this->assertGreaterThanOrEqual(1, $taxonomies->count());
        $this->assertInstanceOf(Taxonomy::class, $taxonomies->first());
    }
}
