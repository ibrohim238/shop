<?php

namespace App\Dto;

use App\Versions\V1\Http\Requests\ProductRequest;

class ProductDto extends BaseDto
{
    public string $name;
    public ?string $description;
    public int $amount;
    public int $price;
    public ?int $new_price;
    public ?array $images;

    public static function fromRequest(ProductRequest $request): ProductDto
    {
        return new self($request->validated());
    }
}
