<?php

namespace App\Validator;

use App\Exception\ValidationException;

class UnsupportedEventValidator implements ValidatorInterface
{
    /**
     * @param array $data
     * @return never
     * @throws ValidationException
     */
    public function validate(array $data): never
    {
        throw new ValidationException('Unsupported event type or type is missing');
    }
}
