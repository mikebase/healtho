<?php

declare(strict_types=1);

namespace Healtho\Shared\Application;

interface Validator
{
    public function validate(Request $request): void;
}
