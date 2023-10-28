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

    public function approveInvoice($id)
    {
        // Find the invoice by ID
        $invoice = Invoice::findOrFail($id);

        // Check if the invoice is in "draft" status
        if ($invoice->status === Invoice::STATUS_DRAFT) {
            // Approve the invoice
            $invoice->status = Invoice::STATUS_APPROVED;
            $invoice->save();

            // Return a success response
            return response()->json(['message' => 'Invoice has been approved.']);
        }

        // Return an error response if the invoice is not in "draft" status
        return response()->json(['message' => 'Invoice cannot be approved.'], 400);
    }

    public function rejectInvoice($id)
    {
        // Find the invoice by ID
        $invoice = Invoice::findOrFail($id);

        // Check if the invoice is in "draft" status
        if ($invoice->status === Invoice::STATUS_DRAFT) {
            // Reject the invoice
            $invoice->status = Invoice::STATUS_REJECTED;
            $invoice->save();

            // Return a success response
            return response()->json(['message' => 'Invoice has been rejected.']);
        }

        // Return an error response if the invoice is not in "draft" status
        return response()->json(['message' => 'Invoice cannot be rejected.'], 400);
    }

}
