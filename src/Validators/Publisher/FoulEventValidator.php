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
            throw new \InvalidArgumentException('match_id, team_id are required for foul events');
        }

        if (!isset($data['player']) || !isset($data['affected_player'])) {
            throw new \InvalidArgumentException('player and affected_player are required for foul events');
        }

        if (!isset($data['minute']) || !isset($data['second'])) {
            throw new \InvalidArgumentException('Time of the foul is required for foul events');
        }

        return true;
    }
}
