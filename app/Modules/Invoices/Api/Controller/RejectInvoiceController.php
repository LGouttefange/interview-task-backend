<?php

namespace App\Modules\Invoices\Api\Controller;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Application\UseCases\RejectInvoice;
use Symfony\Component\HttpFoundation\Response;

class RejectInvoiceController extends Controller
{
    public function __construct(
        private readonly RejectInvoice $rejectInvoice,
    )
    {
    }

    public function __invoke(string $id): Response
    {
        try {
            $this->rejectInvoice->execute($id);
        } catch (\LogicException $e) {
            return response()->json(['error' => $e->getMessage()], 409);
        }

        return response()->noContent();
    }

}
