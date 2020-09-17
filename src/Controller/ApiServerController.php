<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Server;

use App\Service\SerializerService;

/**
 * @Route("/api", name="api_route")
 */
class ApiServerController extends AbstractController
{
    /**
     * @Route("/servers", name="servers_list", methods={"GET"})
     */
    public function serversList(
        Request $request,
        SerializerService $serializerService
    ):JsonResponse
    {
        $servers = $this->getDoctrine()->getRepository(Server::class)->findAll();

        $servers = $serializerService->serialize($servers);
        $response = JsonResponse::fromJsonString($servers);

        return $response;
    }

    /**
     * @Route("/servers/{id}", name="show_server", methods={"GET"})
     */
    public function showServer(
        Server $server,
        Request $request,
        SerializerService $serializerService
    ):JsonResponse {
        $server = $serializerService->serialize($server);
        $response = JsonResponse::fromJsonString($server);

        return $response;
    }

    /**
     * @Route("/servers", name="create_server", methods={"POST"})
     */
    public function createServer(Request $request):JsonResponse
    {
        if (empty($request->request->get('name')) ||
            empty($request->request->get('active')) ||
            empty($request->request->get('customData'))
        ) {
            $response = new JsonResponse(['success' => false], 400);

            return $response;
        }

        try {
            $server = new Server();
            $server->setName($request->request->get('name'));
            $server->setActive($request->request->get('active'));
            $server->setCustomData($request->request->get('customData'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($server);
            $entityManager->flush();

            $response = new JsonResponse(['success' => true], 201);
        } catch (Exception $e) {
            $response = new JsonResponse(['success' => false], 500);
        }

        return $response;
    }

    /**
     * @Route("/servers/{id}", name="update_server", methods={"PUT"})
     */
    public function updateServer(
        Server $server,
        Request $request,
        SerializerService $serializerService
    ):JsonResponse {
        try {
            $server->setName($request->request->get('name'));
            $server->setActive($request->request->get('active'));
            $server->setCustomData($request->request->get('customData'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($server);
            $entityManager->flush();

            $server = $serializerService->serialize($server);
            $response = JsonResponse::fromJsonString($server);
        } catch (Exception $e) {
            $response = new JsonResponse(['success' => false], 500);
        }

        return $response;
    }

    /**
     * @Route("/servers/{id}", name="delete_server", methods={"DELETE"})
     */
    public function deleteServer(Server $server, Request $request):JsonResponse
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($server);
            $entityManager->flush();

            $response = new JsonResponse(['success' => true], 200);
        } catch (Exception $e) {
            $response = new JsonResponse(['success' => false], 500);
        }

        return $response;
    }
}
