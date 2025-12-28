<?php

namespace App\DTO\Models\Project;

use App\Contracts\Models\RequestDTOInterface;
use App\Enums\Models\Project\ProjectStatus;

class CreateProjectDTO implements RequestDTOInterface
{
    public function __construct(
        public string $title,
        public string $description,
        public int $organization_id,
        public ?int $project_manager_id = null,
        public string $start_date = '',
        public string $end_date = '',
        public int $status
    ) {
    }

    /**
     * Static helper to create DTO from the payload
     */
    public static function fromPayload(array $payload): self
    {
        return new self(
            title: $payload['title'],
            description: $payload['description'],
            organization_id: $payload['organization_id'],
            project_manager_id: $payload['project_manager_id'] ?? null,
            start_date: $payload['start_date'] ?? now()->toDateString(),
            end_date: $payload['end_date'] ?? now()->addMonth()->toDateString(),
            status: $payload['status'] ?? ProjectStatus::PLANNING->value
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
