<?php

declare(strict_types=1);

namespace Healtho\Shared\Infrastructure\Symfony\Validator;

use Healtho\Shared\Application\Request;
use Healtho\Shared\Application\Validator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestValidator implements Validator
{
    public function __construct(
        private readonly ValidatorInterface $validator
    ) {
    }

    public function validate(Request $request): void
    {
        $violations = $this->validator->validate($request);

        if ($violations->count() === 0) {
            return;
        }

        $errors = [
            'message' => 'validation_failed',
            'errors' => [],
        ];

        foreach ($violations as $error) {
            $errors['errors'][] = [
                'property' => $error->getPropertyPath(),
                'value' => $error->getInvalidValue(),
                'message' => $error->getMessage(),
            ];
        }

        throw new ValidationException($errors);
    }
}
