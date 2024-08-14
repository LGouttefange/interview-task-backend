<?php

namespace Invoice;

use App\Modules\Invoices\Application\Services\InvoiceTotalsCalculator;
use App\Modules\Invoices\Infrastructure\Database\Factories\InvoiceFactory;
use App\Modules\Invoices\Infrastructure\Database\Factories\InvoiceProductLineFactory;
use App\Modules\Invoices\Infrastructure\Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTotalsTest extends TestCase
{
    use RefreshDatabase;

    private InvoiceTotalsCalculator $totalsCalculator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->totalsCalculator = app(InvoiceTotalsCalculator::class);
    }

    public function test_calculate_invoice_totals()
    {
        $invoice = InvoiceFactory::new()->makeOne();
        $invoice->product_lines->push(
            ...InvoiceProductLineFactory::new([
                'quantity' => 1,
                'product_id' => ProductFactory::new(['price' => 50_00])
            ])->count(2)->make()
        );

        $totals = $this->totalsCalculator->calculate($invoice);

        $this->assertEquals(100_00, $totals->subtotal);
        $this->assertEquals(6_25, $totals->tax);
        $this->assertEquals(106_25, $totals->total);
    }

    public function test_invoice_with_no_lines_has_total_of_zero()
    {
        $invoice = InvoiceFactory::new()->makeOne();

        $totals = $this->totalsCalculator->calculate($invoice);

        $this->assertEquals(0, $totals->subtotal);
        $this->assertEquals(0, $totals->tax);
        $this->assertEquals(0, $totals->total);
    }

}
