<?php

namespace App\Modules\Invoices\Infrastructure\Database\Factories;

use App\Modules\Invoices\Domain\Entities\Invoice;
use App\Modules\Invoices\Domain\Entities\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;
use Random\RandomException;

/**
 * @extends Factory<Invoice>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();

        return [
            'id' => Uuid::uuid4()->toString(),
            'name' => $faker->text('15'),
            'price' => random_int(1111, 9999999),
            'currency' => 'usd',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
