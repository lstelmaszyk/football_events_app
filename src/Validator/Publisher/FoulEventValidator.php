<?php

namespace App\Validator\Publisher;

use App\Enum\EventType;
use App\Validator\AbstractEventValidator;
use App\Validator\ValidatorInterface;
use InvalidArgumentException;

class FoulEventValidator extends AbstractEventValidator implements ValidatorInterface
{
    const TYPE = EventType::FOUL;

    public function validate(array $data): true
    {
        parent::validate($data);

        if (!isset($data['player']) || !isset($data['affected_player'])) {
            throw new InvalidArgumentException('player and affected_player are required for foul events');
        }

        return true;
    }
}
