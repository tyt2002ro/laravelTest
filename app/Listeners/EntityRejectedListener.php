<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Domain\Invoice;


class EntityRejectedListener
{
    public function handle(EntityRejected $event)
    {
        $approvalDto = $event->approvalDto;
        $entity = Invoice::findOrFail($approvalDto->id);
        $entity->status = StatusEnum::tryFrom($approvalDto->status->value);
        $entity->save();
    }
}
