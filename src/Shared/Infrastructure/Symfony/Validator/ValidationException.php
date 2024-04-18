<?php

declare(strict_types=1);

namespace Healtho\Shared\Infrastructure\Symfony\Validator;

use RuntimeException;

class ValidationException extends RuntimeException
{
    /**
     * @var array<mixed>
     */
    private array $errors;

    /**
     * @param array<mixed> $errors
     */
    public function __construct(array $errors, string $message = null)
    {
        $this->errors = $errors;
        parent::__construct($message ?? 'Invalid request', 400);
    }

    /**
     * @return array<mixed>
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
