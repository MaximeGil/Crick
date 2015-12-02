<?php

use Silex\WebTestCase;

class ApiTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../app/app.php';

        return $app;
    }

    public function testJsonResponseContent()
    {
        $excepted = json_encode(array('result' => 'Pong'));
        $client = $this->createClient();
        $client->request('GET', '/api/ping', array(), array(), array('HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'));
        $data = $client->getResponse()->getContent();
        $this->assertEquals($excepted, $data);
    }

    public function testHtmlResponseContent()
    {
        $excepted = '<h1>Pong</h1>';
        $client = $this->createClient();
        $client->request('GET', '/api/ping', array(), array(), array('HTTP_ACCEPT' => 'text/html', 'CONTENT_TYPE' => 'text/html'));
        $data = $client->getResponse()->getContent();
        $this->assertEquals($excepted, $data);
    }

    public function testPrioritiesContent()
    {
        $excepted = '<h1>Pong</h1>';
        $client = $this->createClient();
        $client->request('GET', '/api/ping');
        $data = $client->getResponse()->getContent();
        $this->assertEquals($excepted, $data);
    }
}
