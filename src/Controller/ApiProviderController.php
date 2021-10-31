<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiProviderController extends AbstractController
{
    #[Route('/api/provider/list', name: 'api_get_providers', methods: ["get"])]
    public function index(ProviderRepository $repository): Response
    {
        $providers = $repository->findBy([], ["id" => "ASC"]);
        return $this->json($providers);
    }

    #[Route('/api/provider/{id<\d+>}', name: "api_get_provider", methods: ["get"])]
    public function getProvider(?Provider $provider, int $id): Response
    {
        if (!$provider)
            return $this->json(['error' => 'No provider found for id ' . $id], 404);

        return $this->json($provider);
    }

    #[Route('/api/provider', name: "api_add_provider", methods: ["post"])]
    public function addProvider(Request $request, ValidatorInterface $validator)
    {
        $provider = new Provider();
        $requireFileds = ["name", "surname", "fatherName", "address", "phone"];

        foreach ($requireFileds as $requireFiled)
            if (!$request->request->get($requireFiled))
                return $this->json(["error" => "Missing field \"" . $requireFiled . "\""], 400);

        $provider->setName($request->request->get("name"))
            ->setSurname($request->request->get("surname"))
            ->setFatherName($request->request->get("fatherName"))
            ->setAddress($request->request->get("address"))
            ->setPhone($request->request->get("phone"));

        if ($request->request->get("companyName"))
            $provider->setCompanyName($request->request->get("companyName"));

        $errors = $validator->validate($provider);

        if (count($errors) > 0) {
            return $this->json(["error" => $errors[0]], 400);
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($provider);
        $manager->flush();

        return $this->json(["success" => $provider], 200);
    }

    #[Route('/api/provider/{id<\d+>}', name: "api_edit_provider", methods: ["post"])]
    public function editProvider(?Provider $provider, int $id, Request $request, ValidatorInterface $validator)
    {
        if (!$provider)
            return $this->json(["error" => "No provider found for id " . $id], 404);

        if ($name = $request->request->get("name"))
            $provider->setName($name);
        if ($surname = $request->request->get("surname"))
            $provider->setSurname($surname);
        if ($fatherName = $request->request->get("fatherName"))
            $provider->setFatherName($fatherName);
        if ($address = $request->request->get("address"))
            $provider->setAddress($address);
        if ($phone = $request->request->get("phone"))
            $provider->setPhone($phone);

        $companyName = $request->request->get("companyName");
        if ($companyName)
            $provider->setCompanyName($companyName);
        else if ($companyName == "")
            $provider->setCompanyName(null);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->json(["success" => $provider], 200);
    }

    #[Route('/api/provider/{id<\d+>}', name: "api_remvoe_provider", methods: ["delete"])]
    public function removeProvider(?Provider $provider, int $id)
    {
        if (!$provider)
            return $this->json(["error" => "No provider found for id " . $id], 404);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($provider);
        $entityManager->flush();

        return $this->json(["seccess" => 1]);
    }
}
