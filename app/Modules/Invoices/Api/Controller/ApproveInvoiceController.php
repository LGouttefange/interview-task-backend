<?php

namespace App\Modules\Invoices\Api\Controller;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Application\UseCases\ApproveInvoice;
use Symfony\Component\HttpFoundation\Response;

class ApproveInvoiceController extends Controller
{
    public function __construct(
        private readonly ApproveInvoice $approveInvoice,
    )
    {
    }

    public function __invoke(string $id): Response
    {
        try {
            $this->approveInvoice->execute($id);
        } catch (\LogicException $e) {
            return response()->json(['error' => $e->getMessage()], 409);
        }

        return response()->noContent();
    }

}
