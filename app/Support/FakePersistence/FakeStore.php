<?php

namespace App\Support\FakePersistence;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Simple array-backed fake persistence for API mocking before DB is ready.
 * Uses cache so POST → GET works across HTTP requests during FE development.
 */
class FakeStore
{
    public function __construct(
        private readonly string $key,
        private readonly int $ttlSeconds = 86400,
    ) {
    }

    public function all(): Collection
    {
        return collect($this->read());
    }

    public function find(int $id): ?array
    {
        return $this->all()->firstWhere('id', $id);
    }

    public function where(string $key, mixed $value): Collection
    {
        return $this->all()->filter(fn(array $item) => $item[$key] === $value)->values();
    }

    public function create(array $data): array
    {
        $items = $this->read();
        $data['id'] = count($items) + 1;
        $data['created_at'] = $data['created_at'] ?? now()->toISOString();
        $data['updated_at'] = $data['updated_at'] ?? now()->toISOString();
        $items[] = $data;
        $this->write($items);

        return $data;
    }

    public function update(int $id, array $data): ?array
    {
        $items = $this->read();
        $index = collect($items)->search(fn(array $item) => (int) $item['id'] === $id);

        if ($index === false) {
            return null;
        }

        $items[$index] = array_merge($items[$index], $data, [
            'id' => $id,
            'updated_at' => now()->toISOString(),
        ]);
        $this->write(array_values($items));

        return $items[$index];
    }

    public function delete(int $id): bool
    {
        $items = $this->read();
        $filtered = array_values(array_filter(
            $items,
            fn(array $item) => (int) $item['id'] !== $id
        ));

        if (count($filtered) === count($items)) {
            return false;
        }

        $this->write($filtered);

        return true;
    }

    public function seedIfEmpty(callable $seeder): void
    {
        if ($this->all()->isNotEmpty()) {
            return;
        }

        $seeded = $seeder();
        $this->write(array_values($seeded));
    }

    public function flush(): void
    {
        Cache::forget($this->cacheKey());
    }



    /**
     * Private methods
     */

    private function read(): array
    {
        return Cache::get($this->cacheKey(), []);
    }

    private function write(array $items): void
    {
        Cache::put($this->cacheKey(), $items, $this->ttlSeconds);
    }

    private function cacheKey(): string
    {
        return "fake_store:{$this->key}";
    }
}
