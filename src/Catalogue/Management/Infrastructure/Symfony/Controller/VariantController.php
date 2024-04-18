<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Infrastructure\Symfony\Controller;

use Healtho\Catalogue\Management\Application\Command\CreateVariantHandler;
use Healtho\Catalogue\Management\Application\Command\UpdateVariantHandler;
use Healtho\Catalogue\Management\Application\Request\Variant\CreateVariant;
use Healtho\Catalogue\Management\Application\Request\Variant\UpdateVariant;
use Healtho\Shared\Application\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VariantController extends AbstractController
{
    #[Route('/catalogue/variant/create', name: 'catalogue_variant_create', methods: ['POST'])]
    public function createAction(
        CreateVariant $request,
        Validator $validator,
        CreateVariantHandler $handler
    ): JsonResponse {
        $validator->validate($request);
        $handler->handle($request->toCommand());

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/catalogue/variant/{variantId}/update', name: 'catalogue_variant_update', methods: ['POST'])]
    public function updateAction(
        string $variantId,
        UpdateVariant $request,
        Validator $validator,
        UpdateVariantHandler $handler
    ): JsonResponse {
        $request->id = $variantId;
        $validator->validate($request);
        $handler->handle($request->toCommand());

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
