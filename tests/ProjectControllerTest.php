<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/projects');

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('projectID', $data[0]);
        $this->assertArrayHasKey('projectName', $data[0]);
        $this->assertArrayHasKey('dateOfStart', $data[0]);
        $this->assertArrayHasKey('teamSize', $data[0]);
    }

    public function testNew(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/newproject',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"projectName": "Test Project", "dateOfStart": "2023-01-01", "teamSize": 5}'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testShow(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/projects/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testEdit(): void
    {
        $client = static::createClient();
        $client->request(
            'PUT',
            '/api/projects/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"projectName": "Updated Project", "dateOfStart": "2023-02-01", "teamSize": 10}'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testDelete(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/projects/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testSearchProjects(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/projects/search/projectName/Test');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }
}