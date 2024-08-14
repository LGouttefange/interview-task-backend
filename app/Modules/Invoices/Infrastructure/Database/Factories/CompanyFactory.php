<?php

namespace App\Modules\Invoices\Infrastructure\Database\Factories;

use App\Modules\Invoices\Domain\Entities\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    /**
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();

        return [
            'id' => Uuid::uuid4()->toString(),
            'name' => $faker->company(),
            'street' => $faker->streetAddress(),
            'city' => $faker->city(),
            'zip' => $faker->postcode(),
            'phone' => $faker->phoneNumber(),
            'email' => $faker->safeEmail(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
