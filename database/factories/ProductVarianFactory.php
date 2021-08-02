<?php

namespace Database\Factories;

use App\Models\ProductVarian;
use App\Models\InboundStock;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVarianFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductVarian::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }


    public function configure()
    {
        return $this->afterMaking(function(ProductVarian $productVarian){

        })->afterCreating(function(ProductVarian $productVarian){
            InboundStock::factory()->create([
                'product_varian_id' => $productVarian->id,
                'stock_change' => $productVarian->stock
            ]);
        });
    }

}
