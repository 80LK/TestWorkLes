<?php

namespace App\Controller;

use App\Entity\WoodSpecies;
use App\Repository\WoodSpeciesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiWoodSpeciesController extends AbstractController
{
    #[Route('/api/wood_species/list', name: 'api_woods_species', methods: ["get"])]
    public function index(WoodSpeciesRepository $repository): Response
    {
        $species = $repository->findBy([], ["id" => "ASC"]);

        return $this->json($species);
    }

    #[Route('/api/wood_species/{id<\d+>}', name: "api_wood_species", methods: ["get"])]
    public function getWoodSpecies(int $id): Response
    {
        $provider = $this->getDoctrine()
            ->getRepository(WoodSpecies::class)
            ->find($id);


        if (!$provider)
            return $this->json(['error' => 'No wood species found for id ' . $id], 404);

        return $this->json($provider);
    }
}
