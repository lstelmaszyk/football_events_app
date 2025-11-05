<?php

namespace App\Register;

use App\Validator\UnsupportedEventValidator;
use App\Validator\ValidatorInterface;

class PublisherValidatorsRegister
{
    /**
     * @param array<string, ValidatorInterface> $validators
     */
    public function __construct(private readonly array $validators) {}

    public function getValidatorByType(string|null $type): ValidatorInterface
    {
        return $this->validators[$type] ?? new UnsupportedEventValidator();
    }
}
