<?php

namespace App\Modules\Invoices\Application\UseCases;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepositoryInterface;

readonly class RejectInvoice
{
    public function __construct(
        private ApprovalFacadeInterface $approvalFacade,
        private InvoiceRepositoryInterface $invoiceRepository,
    )
    {
    }


    public function execute(string $rootId): void
    {
        $invoice = $this->invoiceRepository->find($rootId);
        $approvalDto = new ApprovalDto($invoice->uuid(), StatusEnum::tryFrom($invoice->status), $invoice::class);
        $this->approvalFacade->reject($approvalDto);
        $this->invoiceRepository->save($invoice);
    }
}
