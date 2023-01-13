<?php

declare(strict_types=1);

/**
 * Contains the Taxonomies trait.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-13
 *
 */

namespace VaniloCloud\Endpoints;

use VaniloCloud\Models\Taxonomy;

trait Taxonomies
{
    public function taxonomy(string|int $id): ?Taxonomy
    {
        $response = $this->get("/taxonomies/$id");
        if (!$response->successful()) {
            return null;
        }

        return new Taxonomy($this->transpose($response->json(), Taxonomy::class));
    }
}
