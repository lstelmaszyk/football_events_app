<?php

namespace App\Validators\Publisher;

use App\Enums\EventType;
use App\Validators\ValidatorInterface;

class FoulEventValidator implements ValidatorInterface
{
    const TYPE = EventType::FOUL;

    public function validate(array $data): true
    {
        if (!isset($data['match_id']) || !isset($data['team_id'])) {
            throw new \InvalidArgumentException('match_id and team_id are required for foul events');
        }

        return true;
    }
}
