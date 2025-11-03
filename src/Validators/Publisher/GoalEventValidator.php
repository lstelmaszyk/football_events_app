<?php

namespace App\Validators\Publisher;

use App\Enums\EventType;
use App\Validators\AbstractEventValidator;
use App\Validators\ValidatorInterface;
use InvalidArgumentException;

class GoalEventValidator extends AbstractEventValidator implements ValidatorInterface
{
    const TYPE = EventType::GOAL;

    public function validate(array $data): true
    {
        parent::validate($data);

        if (!isset($data['scorer']) || !isset($data['assisting_player'])) {
            throw new InvalidArgumentException('scorer and assisting_player are required for goal events');
        }

        return true;
    }
}
