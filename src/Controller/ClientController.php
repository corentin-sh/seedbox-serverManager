<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Service\SerializerService;

class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client", methods={"GET"})
     */
    public function index()
    {
        return new Response();
    }
}
