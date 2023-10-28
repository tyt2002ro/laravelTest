<?php

declare(strict_types=1);

namespace App\Modules\Approval\Http\Controllers;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Domain\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ApprovalController
{
    protected $approvalFacade;

    public function __construct(ApprovalFacadeInterface $approvalFacade)
    {
        $this->approvalFacade = $approvalFacade;
    }

    public function approveInvoice(Request $request, $id): JsonResponse
    {
        // Find the invoice by ID
        $invoice = Invoice::findOrFail($id);

        // Check if the invoice is in "draft" status
        if (StatusEnum::DRAFT === StatusEnum::tryFrom($invoice->status)) {
            // Create an ApprovalDto
            $approvalDto = new ApprovalDto(
                Uuid::fromString($id),  // Assuming the Invoice has an ID property
                StatusEnum::APPROVED, // Adjust this according to your StatusEnum logic
                'invoice'  // Adjust this according to your requirements
            );

            // Use the ApprovalFacade to approve the entity
            $this->approvalFacade->approve($approvalDto);

            // Return a success response
            return response()->json(['message' => 'Invoice has been approved.']);
        }

        // Return an error response if the invoice is not in "draft" status
        return response()->json(['message' => 'Invoice cannot be approved.'], 400);
    }

    public function rejectInvoice(Request $request, $id): JsonResponse
    {
        // Find the invoice by ID
        $invoice = Invoice::findOrFail($id);

        // Check if the invoice is in "draft" status
        if (StatusEnum::DRAFT === StatusEnum::tryFrom($invoice->status)) {

            // Create an ApprovalDto for rejection
            $rejectedDto = new ApprovalDto(
                Uuid::fromString($id),  // Assuming the Invoice has an ID property
                StatusEnum::REJECTED, // Adjust this according to your StatusEnum logic
                'invoice'  // Adjust this according to your requirements
            );

            // Use the ApprovalFacade to reject the entity
            $this->approvalFacade->reject($rejectedDto);

            // Return a success response
            return response()->json(['message' => 'Invoice has been rejected.']);
        }

        // Return an error response if the invoice is not in "draft" status
        return response()->json(['message' => 'Invoice cannot be rejected.'], 400);
    }
}
