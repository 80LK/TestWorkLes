<?php

namespace App\Controller;

use App\Repository\WoodSpeciesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIWoodSpeciesController extends AbstractController
{
    #[Route('/api/wood_species', name: 'api_wood_species', methods: ["get"])]
    public function index(WoodSpeciesRepository $repository): Response
    {
        $species = $repository->findAll();

        return $this->json($species);
    }
}
