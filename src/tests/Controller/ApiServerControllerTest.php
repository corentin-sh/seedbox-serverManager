<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use App\Entity\User;

class ApiServerControllerTest extends WebTestCase
{
    public function testShowServer()
    {
        $client = static::createClient();

        $client->request('GET', '/api/servers');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testLoginUser()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"username":"admin@admin.com", "password":"password"}'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
