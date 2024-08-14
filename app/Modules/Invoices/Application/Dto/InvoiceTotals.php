<?php

namespace App\Modules\Invoices\Application\Dto;

readonly class InvoiceTotals
{
    public function __construct(
        public int $subtotal,
        public int $tax,
        public int $total,
    )
    {
    }
}
