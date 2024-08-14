<?php

namespace App\Modules\Invoices\Api\Resource;

use App\Modules\Invoices\Domain\ValueObjects\Address;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Address
 */
class AddressResource extends JsonResource
{
    public function __construct(Address $resource)
    {
        parent::__construct($resource);
    }


    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'street' => $this->street,
            'city' => $this->city,
            'zip' => $this->zip,
        ];
    }

}
