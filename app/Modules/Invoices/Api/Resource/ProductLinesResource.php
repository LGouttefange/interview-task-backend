<?php

namespace App\Modules\Invoices\Api\Resource;

use App\Modules\Invoices\Domain\Entities\InvoiceProductLine;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin InvoiceProductLine
 */
class ProductLinesResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'quantity' => $this->quantity,
            'description' => $this->product->name,
            'unit_price' => $this->product->price,
            'amount' => $this->getTotalPrice()->getAmount(),
        ];
    }

}
