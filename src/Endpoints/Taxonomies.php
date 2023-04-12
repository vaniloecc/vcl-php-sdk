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

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
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

    public function taxonomies(): Collection
    {
        $result = collect();
        $response = $this->get('/taxonomies');
        if ($response->successful()) {
            foreach ($response->json('data') as $item) {
                /** @var Taxonomy $taxonomy */
                $taxonomy = new Taxonomy($this->transpose($item, Taxonomy::class));
                $result->put($taxonomy->id, $taxonomy);
            }
        }

        return $result;
    }

    /**
     * Returns the id of the created taxonomy
     */
    public function createTaxonomy(string $name, ?string $slug = null): ?string
    {
        $payload = ['name' => $name];
        if (null !== $slug) {
            $payload['slug'] = $slug;
        }

        $response = $this->post('/taxonomies', $payload);
        if (201 !== $response->status()) {
            return null;
        }

        $urlParts = explode('/', $response->header('Location'));

        return end($urlParts);
    }

    /**
     * @param string|int|Taxonomy $taxonomy
     * @param null|array{name: ?string, slug: ?string} $changes
     * @return bool
     */
    public function updateTaxonomy(string|int|Taxonomy $taxonomy, ?array $changes = null): bool
    {
        if (empty($changes)) {
            if ($taxonomy instanceof Taxonomy) {
                $payload = [
                    'name' => $taxonomy->name,
                    'slug' => $taxonomy->slug,
                ];
            } else {
                return false;
            }
        } else {
            $payload = Arr::only($changes, ['name', 'slug']);
        }

        $id = $taxonomy instanceof Taxonomy ? $taxonomy->id : $taxonomy;

        return $this->patch("/taxonomies/$id", $payload)->successful();
    }

    public function deleteTaxonomy(string|int $id): bool
    {
        return 204 === $this->delete("/taxonomies/$id")->status();
    }
}
