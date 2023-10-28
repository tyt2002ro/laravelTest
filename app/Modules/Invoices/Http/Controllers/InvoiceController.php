<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Http\Controllers;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Infrastructure\DataMappers\InvoiceDataMapper;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{

    public function __construct(private InvoiceDataMapper $invoiceDataMapper)
    {
        // No need for a separate class property
    }

    public function getInvoice($invoiceId): JsonResponse
    {
        $invoice = Invoice::find($invoiceId);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $response = $this->invoiceDataMapper->mapToApiResponse($invoice, $invoiceId);

        return response()->json($response);
    }
}
