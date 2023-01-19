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

namespace VaniloCloud\Tests\Integration;

use PHPUnit\Framework\TestCase;
use VaniloCloud\ApiClient;
use VaniloCloud\Models\Taxonomy;

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
}
