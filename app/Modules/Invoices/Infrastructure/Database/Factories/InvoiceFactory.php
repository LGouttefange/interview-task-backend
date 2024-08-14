<?php

namespace App\Modules\Invoices\Infrastructure\Database\Factories;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Entities\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    /**
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();

        return [
            'id' => Uuid::uuid4()->toString(),
            'number' => $faker->uuid(),
            'date' => $faker->date(),
            'due_date' => $faker->date(),
            'company_id' => CompanyFactory::new(),
            'status' => StatusEnum::cases()[array_rand(StatusEnum::cases())],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
