<?php

use Silex\WebTestCase;

class ContentTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../app/app.php';

        return $app;
    }

    // Test Content Home

    public function testContentHome()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertCount(1, $crawler->filter('h1:contains("Home")'));
    }

    public function testContentHomeWatson()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertCount(1, $crawler->filter('h3:contains("Watson?")'));
    }

    // Test Content Login

    public function testContentLogin()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertCount(1, $crawler->filter('h1:contains("Login")'));
    }

    public function testContentLoginInputUsername()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertCount(1, $crawler->filter('input[type=text]'));
    }

    public function testContentLoginInputPassword()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertCount(1, $crawler->filter('input[type=password]'));
    }

    public function testContentLoginButtonSubmit()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertCount(1, $crawler->filter('button[type=submit]'));
    }

    // Test Content Register

    public function testContentRegister()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/register');
        $this->assertCount(1, $crawler->filter('h1:contains("Register")'));
    }

    public function testContentRegisterInputUsername()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/register');
        $this->assertCount(1, $crawler->filter('input[type=text]'));
    }

    public function testContentRegisterInputPassword()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/register');
        $this->assertCount(2, $crawler->filter('input[type=password]'));
    }

    public function testContentRegisterButtonSubmit()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/register');
        $this->assertCount(1, $crawler->filter('button[type=submit]'));
    }
}
