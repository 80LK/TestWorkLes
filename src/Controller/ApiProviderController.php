<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiProviderController extends AbstractController
{
    #[Route('/api/provider/list', name: 'api_providers', methods: ["get"])]
    public function index(ProviderRepository $repository): Response
    {
        $providers = $repository->findAll();
        return $this->json($providers);
    }

    #[Route('/api/provider/{id<\d+>}', name:"api_provider", methods: ["get"])]
    public function getProvider(int $id): Response
    {
        $provider = $this->getDoctrine()
            ->getRepository(Provider::class)
            ->find($id);


        if (!$provider)
            return $this->json(['error'=>'No provider found for id '.$id], 404);

        return $this->json($provider);
    }
}
