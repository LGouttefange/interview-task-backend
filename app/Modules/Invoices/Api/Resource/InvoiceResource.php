<?php

namespace App\Modules\Invoices\Api\Resource;

use App\Modules\Invoices\Application\Dto\InvoiceTotals;
use App\Modules\Invoices\Domain\Entities\Invoice;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @property Invoice $resource
 */
class InvoiceResource extends JsonResource
{
    public function __construct(Invoice $resource, private readonly InvoiceTotals $totals)
    {
        parent::__construct($resource);
    }
    public function toArray($request): array
    {
        $resource = $this->resource;
        return [
            'number' => $resource->number,
            'date' => $resource->date,
            'due_date' => $resource->due_date,
            'created_at' => $resource->created_at,
            'bill_to' => AddressResource::make($resource->billing_address),
            'ship_to' => AddressResource::make($resource->shipping_address),
            'company' => CompanyResource::make($resource->company),
            'lines' => ProductLinesResource::collection($resource->product_lines),
            'subtotal' => $this->totals->subtotal,
            'tax' => $this->totals->tax,
            'total' => $this->totals->total,
        ];
    }
}
