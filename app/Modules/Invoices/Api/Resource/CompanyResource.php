<?php

namespace App\Modules\Invoices\Api\Resource;

use App\Modules\Invoices\Domain\Entities\Company;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Company
 */
class CompanyResource extends JsonResource
{
    public function __construct(Company $resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'street_address' => $this->street,
            'city' => $this->city,
            'zip_code' => $this->zip,
        ];
    }

}
