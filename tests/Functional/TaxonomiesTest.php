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

    /** @test */
    public function it_can_create_and_delete_a_taxonomy()
    {
        $api = ApiClient::sandbox();
        $taxonomyId = $api->createTaxonomy('Hahaha Test ' . uniqid());
        $this->assertNotNull($taxonomyId);

        $this->assertTrue($api->deleteTaxonomy($taxonomyId));
    }

    /** @test */
    public function it_can_create_then_update_and_delete_a_taxonomy()
    {
        $api = ApiClient::sandbox();
        $uid = uniqid();
        $tid = $api->createTaxonomy('Ergh ergh ergh test  ' . $uid);
        $this->assertNotNull($tid);

        $this->assertTrue($api->updateTaxonomy($tid, ['name' => "Fixed $uid"]));

        $this->assertEquals("Fixed $uid", $api->taxonomy($tid)?->name);

        $this->assertTrue($api->deleteTaxonomy($tid));
    }

    /** @ test */
    public function the_list_of_taxonomies_can_be_filtered()
    {
        $api = ApiClient::sandbox();

        $taxonomies = $api->taxonomies(Where::createdAfter('2022-12-01T12:00:00'));
        $taxonomies = $api->taxonomies(Where::slugIs('sad'));
        $taxonomies = $api->taxonomies(Where::slugLike('cat*'));
        $taxonomies = $api->taxonomies(Where::nameIs('Category'));
        $taxonomies = $api->taxonomies(Where::nameLike('Cat*'));
        $taxonomies = $api->taxonomies(Where::nameLike('Cat*')->andUpdatedAfter('2022-12-31T23:59:59'));

        $this->assertInstanceOf(Collection::class, $taxonomies);
        $this->assertGreaterThanOrEqual(1, $taxonomies->count());
        $this->assertInstanceOf(Taxonomy::class, $taxonomies->first());
    }
}
