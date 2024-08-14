<?php

namespace App\Modules\Invoices\Infrastructure\Database\Factories;

use App\Modules\Invoices\Domain\Entities\InvoiceProductLine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends Factory<InvoiceProductLine>
 */
class InvoiceProductLineFactory extends Factory
{
    protected $model = InvoiceProductLine::class;

    /**
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();

        return [
            'id' => Uuid::uuid4()->toString(),
            'product_id' => ProductFactory::new(),
            'quantity' => rand(1, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
