<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getTotal(): float
    {
        return ($this['pivot']['quantity'] ?? 0) * (float)$this->getPrice();
    }
}
