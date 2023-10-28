<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Invoices\Domain\Invoice;


class EntityApprovedListener
{
    public function handle(EntityApproved $event)
    {
        $approvalDto = $event->approvalDto;
        $entity = Invoice::findOrFail($approvalDto->id);
        $entity->status = StatusEnum::tryFrom($approvalDto->status->value);
        $entity->save();
    }
}
