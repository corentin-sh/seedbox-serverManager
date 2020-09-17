<?php

namespace App\Service;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class GuzzleService
{
    private $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $_ENV['API_SERVER_URL']
        ]);
    }

    public function get($url, $apiToken)
    {
        $response = $this->client->request('GET', $url, [
            'headers' => [
                'AUTH-TOKEN' => $apiToken,
                'Content-Type' => 'application/json',
            ]
        ]);

        return $response;
    }

    public function post($url, $apiToken, $data)
    {
        $response = $this->client->request('POST', $url, [
            'form_params' => $data,
            'headers' => [
                'AUTH-TOKEN' => $apiToken
            ]
        ]);

        return $response;
    }

    public function put($url, $apiToken, $data)
    {
        $response = $this->client->request('PUT', $url, [
            'form_params' => $data,
            'headers' => [
                'AUTH-TOKEN' => $apiToken
            ]
        ]);

        return $response;
    }

    public function delete($url, $apiToken)
    {
        $response = $this->client->request('DELETE', $url, [
            'headers' => [
                'AUTH-TOKEN' => $apiToken
            ]
        ]);

        return $response;
    }
}
