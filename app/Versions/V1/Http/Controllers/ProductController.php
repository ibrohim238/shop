<?php

namespace App\Versions\V1\Http\Controllers;

use App\Dto\ProductDto;
use App\Models\Product;
use App\Versions\V1\Http\Requests\ProductRequest;
use App\Versions\V1\Http\Resources\ProductCollection;
use App\Versions\V1\Http\Resources\ProductResource;
use App\Versions\V1\Repositories\ProductRepository;
use App\Versions\V1\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class);
    }

    public function index(Request $request)
    {
        $products = app(ProductRepository::class)->paginate($request->get('count'));

        return new ProductCollection($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(ProductRequest $request)
    {
        $product = app(ProductService::class)
            ->store(ProductDto::fromRequest($request));

        return new ProductResource($product);
    }

    public function update(Product $product, ProductRequest $request)
    {
        app(ProductService::class, [
          'product' => $product
        ])->update(ProductDto::fromRequest($request));

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        app(ProductService::class, [
            'product' => $product
        ])->destroy();

        return response()->noContent();
    }
}
