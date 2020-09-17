<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Service\GuzzleService;

class ClientController extends AbstractController
{
    /**
     * @Route("/", name="home_client")
     */
    public function home(GuzzleService $guzzleService)
    {
        $user = $this->getUser();
        $response = $guzzleService->get('api/servers', $user->getApiToken());

        $response = json_decode($response->getBody(), true);
        return new JsonResponse($response);
    }

    /**
     * @Route("/servers/{id}", name="show_client_server", methods={"GET"})
     */
    public function showServer(int $id, GuzzleService $guzzleService)
    {
        $user = $this->getUser();
        $response = $guzzleService->get(
            'api/servers/'.$id,
            $user->getApiToken()
        );

        $response = json_decode($response->getBody(), true);
        return new JsonResponse($response);
    }

    /**
     * @Route("/servers", name="create_client_server", methods={"POST"})
     */
    public function createServer(
        Request $request,
        GuzzleService $guzzleService
    ): JsonResponse {
        $data = [
            'name' => $request->get('name'),
            'active' => $request->get('active'),
            'customData' => $request->get('customData')
        ];

        $user = $this->getUser();
        $response = $guzzleService->post(
            'api/servers',
            $user->getApiToken(),
            $data
        );

        $response = json_decode($response->getBody(), true);
        return new JsonResponse($response);
    }

    /**
     * @Route("/servers/{id}", name="update_client_server", methods={"PUT"})
     */
    public function updateServer(
        int $id,
        Request $request,
        GuzzleService $guzzleService
    ): JsonResponse {
        $data = [
            'name' => $request->get('name'),
            'active' => $request->get('active'),
            'customData' => $request->get('customData')
        ];

        $user = $this->getUser();
        $response = $guzzleService->put(
            'api/servers/'.$id,
            $user->getApiToken(),
            $data
        );

        $response = json_decode($response->getBody(), true);
        return new JsonResponse($response);
    }

    /**
     * @Route("/servers/{id}", name="delete_client_server", methods={"DELETE"})
     */
    public function deleteServer(
        int $id,
        GuzzleService $guzzleService
    ): JsonResponse {
        $user = $this->getUser();
        $response = $guzzleService->delete(
            'api/servers/'.$id,
            $user->getApiToken()
        );

        $response = json_decode($response->getBody(), true);
        return new JsonResponse($response);
    }
}
