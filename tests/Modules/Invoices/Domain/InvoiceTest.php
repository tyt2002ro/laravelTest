<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain;

use App\Modules\Invoices\Domain\Invoice;
use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{
    public function testTotalAmountAttribute(): void
    {
        // Create an instance of the Invoice model
        $invoice = new Invoice();

        // Mock products with some pivot data
        $product1 = (object)['price' => 10];
        $product2 = (object)['price' => 15];

        // Pivot data for products
        $product1->pivot = (object)['quantity' => 2, 'invoice_id' => 'invoice_1'];
        $product2->pivot = (object)['quantity' => 3, 'invoice_id' => 'invoice_1'];

        // Set products on the invoice
        $invoice->products = [$product1, $product2];

        // Calculate the total amount
        $totalAmount = $invoice->getTotalAmountAttribute('invoice_1');

        // Assert that the total amount is calculated correctly
        $this->assertEquals(2 * 10 + 3 * 15, $totalAmount);
    }
}
