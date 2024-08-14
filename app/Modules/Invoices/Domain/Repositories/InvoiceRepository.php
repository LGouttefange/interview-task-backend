<?php

namespace App\Modules\Invoices\Domain\Repositories;

use App\Modules\Invoices\Domain\Entities\Invoice;
use Ramsey\Uuid\UuidInterface;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function find(UuidInterface|string $uuid): Invoice
    {
        return Invoice::findOrFail((string)$uuid);
    }

    /**
     * @throws \Throwable
     */
    public function save(Invoice $invoice): void
    {
        $invoice->saveOrFail();
    }
}
