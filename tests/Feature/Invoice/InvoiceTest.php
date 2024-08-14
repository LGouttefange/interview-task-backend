<?php

namespace Invoice;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Infrastructure\Database\Factories\InvoiceFactory;
use App\Modules\Invoices\Infrastructure\Database\Factories\InvoiceProductLineFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }


    public function test_show_invoice_data()
    {
        $invoice = InvoiceFactory::new()
            ->has(InvoiceProductLineFactory::new()->count(3), 'product_lines')
            ->createOne(['status' => StatusEnum::DRAFT]);

        $response = $this->get("/api/invoices/{$invoice->id}");
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'number',
                'date',
                'due_date',
                'created_at',
                'bill_to',
                'ship_to',
                'company',
                'subtotal',
                'tax',
                'total',
                'lines' => [
                    '*' => [
                        'quantity',
                        'description',
                        'unit_price',
                        'amount',
                    ]],
            ]
        ]);
    }

    public function test_invoice_can_be_approved()
    {
        $invoice = InvoiceFactory::new()->createOne(['status' => StatusEnum::DRAFT]);

        $response = $this->post("/api/invoices/{$invoice->id}/approve");
        $response->assertSuccessful();

        Event::assertDispatched(EntityApproved::class);
    }

    public function test_invoice_with_decision_cannot_be_approved_again()
    {
        $invoice = InvoiceFactory::new()->createOne(['status' => StatusEnum::APPROVED]);

        $response = $this->post("/api/invoices/{$invoice->id}/approve");
        $this->assertTrue($response->isClientError());

        Event::assertNotDispatched(EntityApproved::class);
    }

    public function test_invoice_can_be_rejected()
    {
        $invoice = InvoiceFactory::new()->createOne(['status' => StatusEnum::DRAFT]);

        $response = $this->post("/api/invoices/{$invoice->id}/reject");
        $response->assertSuccessful();

        Event::assertDispatched(EntityRejected::class);
    }

}
