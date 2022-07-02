<?php

namespace App\Versions\V1\Services;

use App\Dto\ProductDto;
use App\Models\Product;
use App\Versions\V1\Repositories\ProductRepository;

class ProductService
{
    private ProductRepository $repository;

    public function __construct(
        private Product $product
    ) {
        $this->repository = app(ProductRepository::class, [
           'product' => $this->product
        ]);
    }

    public function store(ProductDto $dto): Product
    {
        $this->repository
            ->fill($dto)
            ->save()
            ->addMedia($dto->images);

        return $this->product;
    }

    public function update(ProductDto $dto): Product
    {
        $this->repository
            ->fill($dto)
            ->save()
            ->addMedia($dto->images);

        return $this->product;
    }

    public function destroy(): void
    {
        $this->repository
            ->delete();
    }
}
