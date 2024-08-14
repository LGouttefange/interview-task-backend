<?php

namespace App\Modules\Invoices\Application\Services;

use App\Modules\Invoices\Application\Dto\InvoiceTotals;
use App\Modules\Invoices\Domain\Entities\Invoice;
use App\Modules\Invoices\Domain\Entities\InvoiceProductLine;
use Money\Money;

class InvoiceTotalsCalculator
{
    private const SALES_TAX = '0.0625';

    public function calculate(Invoice $invoice): InvoiceTotals
    {
        if ($invoice->product_lines->isEmpty()) {
            return new InvoiceTotals(
                0,
                self::SALES_TAX,
                0,
            );
        }


        $subtotal = Money::sum(
            ...$invoice->product_lines->map(fn(InvoiceProductLine $line) => $line->getTotalPrice())
        );

        $tax = $subtotal->multiply(self::SALES_TAX);

        return new InvoiceTotals(
            $subtotal->getAmount(),
            $tax->getAmount(),
            $subtotal->add($tax)->getAmount(),
        );
    }

}
