<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Entity\Provider;
use App\Repository\DeliveryRepository;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiDeliveryController extends AbstractController
{
    public function custom_json($data, int $status = 200, $headers = [], $context = []){
        $context[AbstractNormalizer::IGNORED_ATTRIBUTES] =['__initializer__', '__cloner__', '__isInitialized__'];
        return parent::json($data, $status, $headers, $context);
    }

    #[Route('/api/delivery/list', name: 'api_deliveries', methods: ["get"])]
    public function index(DeliveryRepository $repository): Response
    {
        $deliveries = $repository->findAll();

        return $this->custom_json($deliveries);
    }

    #[Route('/api/delivery/{id<\d+>}', name:"api_delivery", methods: ["get"])]
    public function getDelivery(int $id){
        $delivery = $this->getDoctrine()
            ->getRepository(Delivery::class)
            ->find($id);

        if (!$delivery)
            return $this->json(['error'=>'No delivery found for id '.$id], 404);

        return $this->custom_json($delivery);
    }
}
