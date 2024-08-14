<?php

namespace App\Modules\Invoices\Domain\ValueObjects;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class Address implements Castable
{
    public function __construct(
        public string $name,
        public string $street,
        public string $city,
        public string $zip,
    )
    {
    }


    public static function castUsing(array $arguments)
    {
        return new class implements CastsAttributes {

            /**
             * @param Model $model
             * @param string $key
             * @param mixed $value
             * @param array $attributes
             * @return Address
             */
            public function get($model, $key, $value, $attributes)
            {
                return new Address(
                    $attributes["{$key}_name"],
                    $attributes["{$key}_street"],
                    $attributes["{$key}_city"],
                    $attributes["{$key}_zip"],
                );
            }

            /**
             * @param Model $model
             * @param string $key
             * @param Address $value
             * @param array $attributes
             * @return array
             */
            public function set($model, $key, $value, $attributes)
            {
                if (!$value instanceof Address) {
                    throw new InvalidArgumentException('The given value is not an Address instance.');
                }

                return [
                    "{$key}_name" => $value->name,
                    "{$key}_street" => $value->street,
                    "{$key}_city" => $value->city,
                    "{$key}_zip" => $value->zip,
                ];
            }
        };
    }
}
