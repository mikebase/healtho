<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Infrastructure\Symfony\Controller;

use Healtho\Catalogue\Management\Application\Command\CreateProductHandler;
use Healtho\Catalogue\Management\Application\Command\UpdateProductHandler;
use Healtho\Catalogue\Management\Application\Query\GetAllProducts;
use Healtho\Catalogue\Management\Application\Request\Product\CreateProduct;
use Healtho\Catalogue\Management\Application\Request\Product\UpdateProduct;
use Healtho\Shared\Application\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/catalogue/product/list', name: 'catalogue_product_list', methods: ['GET'])]
    public function listAction(GetAllProducts $getAllProducts): JsonResponse
    {
        $products = $getAllProducts->getResult();
        return $this->json($products);
    }

    #[Route('/catalogue/product/create', name: 'catalogue_product_create', methods: ['POST'])]
    public function createAction(
        CreateProduct $request,
        Validator $validator,
        CreateProductHandler $handler
    ): JsonResponse {
        $validator->validate($request);
        $handler->handle($request->toCommand());

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/catalogue/product/{productId}/update', name: 'catalogue_product_update', methods: ['POST'])]
    public function updateAction(
        string $productId,
        UpdateProduct $request,
        Validator $validator,
        UpdateProductHandler $handler
    ): JsonResponse {
        $request->id = $productId;
        $validator->validate($request);
        $handler->handle($request->toCommand());

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
