<?php

namespace App\Modules\Invoices\Domain\Repositories;

use App\Modules\Invoices\Domain\Entities\Invoice;
use Ramsey\Uuid\UuidInterface;

interface InvoiceRepositoryInterface
{
    public function find(UuidInterface|string $uuid): Invoice;

    /**
     * @throws \Throwable
     */
    public function save(Invoice $invoice): void;
}
