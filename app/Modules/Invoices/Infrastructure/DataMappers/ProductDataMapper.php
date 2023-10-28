<?php
declare(strict_types=1);
namespace App\Modules\Invoices\Infrastructure\DataMappers;

use App\Modules\Invoices\Domain\Product;

class ProductDataMapper
{
    public function mapToApiResponse(Product $product): array
    {
        return [
            'Name' => $product->getName(),
            'Quantity' => $product['pivot']['quantity'] ?? '',
            'Unit Price' => $product->getPrice(),
            'Total' => $product->getTotal(),
        ];
    }
}
