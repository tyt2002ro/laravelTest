<?php

declare(strict_types=1);

namespace App\Modules\Approval\Api\Events;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\Dto\ApprovalDto;

final readonly class EntityRejected
{
    public function __construct(
        public ApprovalDto $approvalDto
    ) {
    }

    public function handle(EntityApproved $event)
    {
        die('aaa');
        $approvalDto = $event->approvalDto;
        $entity = $approvalDto->entity;

        $entity->status = StatusEnum::REJECTED->value;
        $entity->save();
    }
}
