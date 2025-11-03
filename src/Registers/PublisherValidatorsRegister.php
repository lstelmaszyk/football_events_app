<?php

namespace App\Registers;

use App\Validators\UnsupportedEventValidator;
use App\Validators\ValidatorInterface;

class PublisherValidatorsRegister
{
    /**
     * @param array<string, ValidatorInterface> $validators
     */
    public function __construct(private readonly array $validators) {}

    public function getValidatorByType(string $type): ValidatorInterface
    {
        return $this->validators[$type] ?? new UnsupportedEventValidator();
    }
}
