<?php


namespace App\Validators;

use InvalidArgumentException;

class AbstractEventValidator implements ValidatorInterface
{
    public function validate(array $data): true
    {
        if (!isset($data['match_id']) || !isset($data['team_id'])) {
            throw new InvalidArgumentException('match_id, team_id are required for events');
        }

        if (!isset($data['minute']) || !isset($data['second'])) {
            throw new InvalidArgumentException('Time of the foul is required for events');
        }

        return true;
    }
}
