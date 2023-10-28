<?php
declare(strict_types=1);
namespace App\Modules\Invoices\Domain;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{

    const STATUS_DRAFT = 'draft';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function billedCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'invoice_product_lines', 'invoice_id', 'product_id')
            ->withPivot('quantity')
            ->wherePivot('invoice_id', $this->id);
    }

    public function getTotalAmountAttribute(): float
    {
        return $this->products->sum(function ($product) {
            return $product->pivot->quantity * $product->price;
        });
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function getDueDate(): ?string
    {
        return $this->due_date;
    }

    public function getCompanyId(): ?string
    {
        return $this->company_id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }
}
