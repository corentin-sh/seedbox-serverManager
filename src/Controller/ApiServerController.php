<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use App\Entity\Server;

use App\Service\SerializerService;

/**
 * @Route("/api", name="api_route")
 */
class ApiServerController extends AbstractController
{
    /**
     * @Route("/servers", name="api_servers")
     */
    public function servers(Request $request, SerializerService $serializerService)
    {
        $servers = $this->getDoctrine()->getRepository(Server::class)->findAll();
        $servers = $serializerService->serialize($servers);

        $response = new Response($servers);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
