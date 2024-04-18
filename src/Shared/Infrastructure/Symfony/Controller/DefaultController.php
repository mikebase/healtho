<?php

declare(strict_types=1);

namespace Healtho\Shared\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_index', methods: ['GET'])]
    public function indexAction(): Response
    {
        return $this->json([
            'status' => 'OK',
        ]);
    }
}
