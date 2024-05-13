<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'quantity' => $this->pivot->quantity,
            'unit_price' => $this->price,
            'total' => $this->price * $this->pivot->quantity,
        ];
    }
}
