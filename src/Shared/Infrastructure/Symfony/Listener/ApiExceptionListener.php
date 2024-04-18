<?php

declare(strict_types=1);

namespace Healtho\Shared\Infrastructure\Symfony\Listener;

use Healtho\Shared\Infrastructure\Symfony\Validator\ValidationException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ApiExceptionListener
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $env = $this->parameterBag->get('kernel.environment');
        $exception = $event->getThrowable();
        $content = [];

        if ($exception instanceof ValidationException) {
            $code = Response::HTTP_BAD_REQUEST;
            $content['errors'] = $exception->errors();
        } else {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            if ($env !== 'prod') {
                $content['errors']['server'] = sprintf('%s - %s', $exception::class, $exception->getMessage());
            }
        }

        $event->setResponse(new JsonResponse($content, $code));
    }
}
