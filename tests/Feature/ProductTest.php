<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Versions\V1\Http\Resources\ProductCollection;
use App\Versions\V1\Http\Resources\ProductResource;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use WithFaker;

    private User $user;

    public function testIndexOk()
    {
        $products = Product::factory()->count(5)->create();

        $response = $this->getJson(route('product.index'));

        $response->assertOk()
            ->assertJsonFragment(
                (new ProductCollection($products))->response()->getData(true)
            );
    }

    public function testShowOk()
    {
        $product = Product::factory()->create();
        $response = $this->getJson(route('product.show', $product));

        $response->assertOk()
            ->assertJsonFragment(
                (new ProductResource($product))->response()->getData(true)
            );
    }

    public function testShowNotFound()
    {
        $response = $this->getJson(route('product.show', 'n'));

        $response->assertNotFound();
    }

    public function testStoreOk()
    {
        $price = $this->faker->numberBetween(100, 10000);

        $response = $this->actingAs($this->user)
            ->postJson(route('product.store'), [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'amount' => $this->faker->numberBetween(0, 100),
                'price' => $this->faker->numberBetween(100, 10000),
                'new_price' => $this->faker->randomElement([
                    $this->faker->numberBetween(0, $price - 1),
                    null
                ])
            ]);

        $response->assertCreated();
    }

    public function testUpdateOk()
    {
        $product = Product::factory()->create();
        $price = $this->faker->numberBetween(100, 10000);

        $response = $this->actingAs($this->user)
            ->patchJson(route('product.update', $product), [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'amount' => $this->faker->numberBetween(0, 100),
                'price' => $this->faker->numberBetween(100, 10000),
                'new_price' => $this->faker->randomElement([
                    $this->faker->numberBetween(0, $price - 1),
                    null
                ])
            ]);

        $response->assertOk();
    }

    public function testUpdateNotFound()
    {
        $price = $this->faker->numberBetween(100, 10000);

        $response = $this->actingAs($this->user)
            ->patchJson(route('product.update', 'n'), [
                'name' => $this->faker->name,
                'description' => $this->faker->text,
                'amount' => $this->faker->numberBetween(0, 100),
                'price' => $this->faker->numberBetween(100, 10000),
                'new_price' => $this->faker->randomElement([
                    $this->faker->numberBetween(0, $price - 1),
                    null
                ])
            ]);

        $response->assertNotFound();
    }

    public function testDestroyOk()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('product.destroy', $product));

        $response->assertNoContent();
    }

    public function testDestroyNotFound()
    {
        $response = $this->actingAs($this->user)
            ->deleteJson(route('product.destroy', 'n'));

        $response->assertNotFound();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

    }
}
