<?php
use Silex\WebTestCase;


class ContentTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../app/app.php';
        return $app;
    }

        public function testContentHome()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h1:contains("Hello World")'));
    }

    public function testContentRegister()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/contact');
        $this->assertTrue($client->getResponse()->isOk());

    }

}