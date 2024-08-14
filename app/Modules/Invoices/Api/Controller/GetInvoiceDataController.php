<?php

namespace App\Modules\Invoices\Api\Controller;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Api\Resource\InvoiceResource;
use App\Modules\Invoices\Application\Services\InvoiceTotalsCalculator;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Uuid\Uuid;

class GetInvoiceDataController extends Controller
{
    public function __construct(
        private readonly InvoiceRepositoryInterface $invoiceRepository,
        private readonly InvoiceTotalsCalculator $invoiceTotalsCalculator,
    )
    {
    }


    public function __invoke(string $id): JsonResource
    {
        $invoice = $this->invoiceRepository->find(Uuid::fromString($id));
        $totals = $this->invoiceTotalsCalculator->calculate($invoice);

        return new InvoiceResource($invoice, $totals);
    }

}
