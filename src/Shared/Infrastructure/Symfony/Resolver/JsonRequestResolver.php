<?php

declare(strict_types=1);

namespace Healtho\Shared\Infrastructure\Symfony\Resolver;

use Exception;
use Healtho\Shared\Application\Request;
use Healtho\Shared\Infrastructure\Symfony\Validator\ValidationException;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

class JsonRequestResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer
    ) {
    }

    /**
     * @throws ValidationException
     * @return \Generator
     */
    public function resolve(HttpFoundationRequest $request, ArgumentMetadata $argument): iterable
    {
        $type = (string) $argument->getType();

        if (! $this->supports($type)) {
            return;
        }

        try {
            yield $this->serializer->deserialize($request->getContent(), $type, 'json');
        } catch (Exception) {
            throw new ValidationException([], 'Invalid JSON data.');
        }
    }

    private function supports(string $type): bool
    {
        if (! class_exists($type)) {
            return false;
        }

        $interfaces = class_implements($type);
        return $interfaces && in_array(Request::class, $interfaces, true);
    }
}
