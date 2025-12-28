<?php

namespace App\Contracts\Models;

interface RequestDTOInterface
{
    public function toArray(): array;
    public static function fromPayload(array $payload): self;
}
