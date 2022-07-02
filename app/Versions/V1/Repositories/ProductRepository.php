<?php

namespace App\Versions\V1\Repositories;

use App\Dto\ProductDto;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository
{
    public function __construct(
      private Product $product
    ) {
    }

    public function paginate(?int $perPage): LengthAwarePaginator
    {
        return Product::query()->paginate($perPage);
    }

    public function fill(ProductDto $dto): static
    {
        $this->product->fill($dto->toArray());

        return $this;
    }

    public function save(): static
    {
        $this->product->save();

        return $this;
    }

    public function addMedia(?array $images)
    {
        if (! empty($images)) {
            $this->product->clearMediaCollection();
            $this->product->addMultipleMediaFromRequest(['images'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection();
                });
        }
    }

    public function delete(): static
    {
        $this->product->delete();

        return $this;
    }
}
