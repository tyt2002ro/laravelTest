<?php
declare(strict_types=1);
namespace App\Modules\Invoices\Infrastructure\DataMappers;

use App\Modules\Invoices\Domain\Invoice;

class InvoiceDataMapper
{
    public function __construct(
        private CompanyDataMapper $companyDataMapper,
        private ProductDataMapper $productDataMapper,
    )
    {
        // No need for a separate class property
    }
    /**
     * @param Invoice $invoice
     * @return array
     */
    public function mapToApiResponse(Invoice $invoice, string $invoiceId): array
    {

        return [
            'Invoice number' => $invoice->getNumber(),
            'Invoice date' => $invoice->getDate(),
            'Due date' => $invoice->getDueDate(),
            'Status' => $invoice->getStatus(),

            'Company' => $this->companyDataMapper->mapToApiResponse($invoice->company),
            'Billed company' => $this->companyDataMapper->mapToApiResponse($invoice->billedCompany),
            'Products' => $this->parseMapProducts($invoice->products, $invoiceId),
            'Total price' => $invoice->getTotalAmountAttribute($invoiceId),
        ];
    }

    public function parseMapProducts($products, string $invoiceId): array
    {
        $productsData = [];
        foreach ($products as $product) {
            if($product['pivot']['invoice_id'] === $invoiceId) {
                $productsData[] = $this->productDataMapper->mapToApiResponse($product);
            }
        }
        return $productsData;
    }
}
