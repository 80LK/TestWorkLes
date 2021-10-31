<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Entity\Provider;
use App\Entity\WoodSpecies;
use App\Repository\DeliveryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiDeliveryController extends AbstractController
{
    #[Route('/api/delivery/list', name: 'api_deliveries', methods: ["get"])]
    public function index(DeliveryRepository $repository): Response
    {
        $deliveries = $repository->findAll();

        return $this->custom_json($deliveries);
    }

    private function custom_json($data, int $status = 200, $headers = [], $context = [])
    {
        $context[AbstractNormalizer::IGNORED_ATTRIBUTES] = ['__initializer__', '__cloner__', '__isInitialized__'];
        return parent::json($data, $status, $headers, $context);
    }

    #[Route('/api/delivery/{id<\d+>}', name: "api_delivery", methods: ["get"])]
    public function getDelivery(?Delivery $delivery, int $id)
    {
        if (!$delivery)
            return $this->json(['error' => 'No delivery found for id ' . $id], 404);

        return $this->custom_json($delivery);
    }

    #[Route('/api/delivery', name: "api_add_delivery", methods: ["post"])]
    public function addDelivery(Request $request, ValidatorInterface $validator)
    {
        $delivery = new Delivery();
        $requireFileds = ["provider", "woodSpecies", "volume", "date"];

        foreach ($requireFileds as $requireFiled)
            if (!$request->request->get($requireFiled))
                return $this->json(["error" => "Missing field \"" . $requireFiled . "\""], 400);

        $dateRaw = $request->request->get("date");
        $date = \DateTimeImmutable::createFromFormat(\DateTimeInterface::ATOM, $dateRaw);
        if (!$date) $date = \DateTimeImmutable::createFromFormat(\DateTimeInterface::ISO8601, $dateRaw);
        if (!$date) return $this->json(["error" => "Date was been ISO8601 format"], 400);

        $manager = $this->getDoctrine()->getManager();

        $providerId = (int)$request->request->get("provider");
        $provider = $manager->getRepository(Provider::class)->find($providerId);
        if (!$provider)
            return $this->json(['error' => 'No provider found for id ' . $providerId], 400);

        $woodSpeciesId = (int)$request->request->get("provider");
        $woodSpecies = $manager->getRepository(WoodSpecies::class)->find($woodSpeciesId);
        if (!$woodSpecies)
            return $this->json(['error' => 'No provider found for id ' . $woodSpeciesId], 400);

        $delivery->setDate($date)
            ->setVolume($request->request->get("volume"))
            ->setProvider($provider)
            ->setWoodSpecies($woodSpecies);

        if ($request->request->get("note"))
            $delivery->setNote($request->request->get("note"));

        $errors = $validator->validate($delivery);

        if (count($errors) > 0)
            return $this->json(["error" => $errors[0]], 400);

        $manager->persist($delivery);
        $manager->flush();

        return $this->json(["success" => $delivery]);
    }
}
