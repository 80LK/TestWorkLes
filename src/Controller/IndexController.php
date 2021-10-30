<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Entity\Provider;
use App\Entity\WoodSpecies;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route("/{vueRouting}", name: "index", requirements: ["vueRouting"=>"^(?!api|_(profiler|wdt)).*"])]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }
}
