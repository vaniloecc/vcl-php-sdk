<?php

declare(strict_types=1);

/**
 * Contains the RawResponsesTest class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-30
 *
 */

namespace VaniloCloud\Tests\Functional;

use Illuminate\Http\Client\Response;
use PHPUnit\Framework\TestCase;
use VaniloCloud\ApiClient;

class RawResponsesTest extends TestCase
{
    /** @test */
    public function the_raw_get_method_returns_the_list_of_taxonomies_as_illuminate_http_response()
    {
        $response = ApiClient::sandbox()->rawGet('/taxonomies?include=images');

        $this->assertInstanceOf(Response::class, $response);
        $responseData = $response->json('data');
        $this->assertIsArray($responseData);
        $this->assertGreaterThanOrEqual(1, count($responseData));
        // The default taxonomy should be there
        $defaultCategory = collect($responseData)->keyBy('slug')->get('category');
        $this->assertIsArray($defaultCategory);
        $this->assertArrayHasKey('id', $defaultCategory);
        $this->assertArrayHasKey('name', $defaultCategory);
        $this->assertArrayHasKey('created_at', $defaultCategory);
        $this->assertArrayHasKey('updated_at', $defaultCategory);
        $this->assertArrayHasKey('images', $defaultCategory);
    }

    /** @test */
    public function it_gives_a_422_response_when_validation_fails()
    {
        $sku = uniqid();
        $api = ApiClient::sandbox();

        try {
            $api->rawPost('/products', ['name' => "test $sku", 'sku' => $sku]);

            $response = $api->rawPost('/products', ['name' => "test $sku", 'sku' => $sku]);
            $this->assertEquals(422, $response->status());
        } finally {
            $api->rawDelete("/products/$sku");
        }
    }
}
