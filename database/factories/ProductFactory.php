<?php

namespace Database\Factories;

use App\Models\InboundStock;
use App\Models\Product;
use App\Models\ProductVarian;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\File;
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text()
        ];
    }

    public function configure()
    {

        return $this->afterMaking(function (Product $product){
            $product->image = $this->faker->file(resource_path('dashboard/img/sample-product'), storage_path('app/public/products/'), false);
        })->afterCreating(function (Product $product){
            ProductVarian::withoutEvents(function() use($product){
                ProductVarian::factory()
                ->state(
                    new Sequence(
                        [
                            'name' => 'merah',
                            'stock' => 10
                        ],
                        [
                            'name' => 'biru',
                            'stock' => 15
                        ],
                        [
                            'name' => 'coklat',
                            'stock' => 20
                        ],
                        [
                            'name' => 'hijau',
                            'stock' => 14
                        ],
                        [
                            'name' => 'hitam',
                            'stock' => 19
                        ],
                    )
                )
                ->count(3)
                ->create([
                    'product_id' => $product->id
                ]);
            });
        });
    }
}
