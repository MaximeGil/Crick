<?php

use Ramsey\Uuid\Uuid;
use crick\Security\Api\ApiKeyGenerator;

class ApiTest extends PHPUnit_Framework_TestCase
{
    protected $app;
    protected $client;
    protected $uuid;
    protected $email;
    protected $password;
    protected $role;
    protected $api;
    protected $query;
    protected $response;

    protected function setUp()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'http://localhost/crick/crick/web/index.php/api/']);

        $this->uuid = Uuid::uuid1()->toString();
        $this->email = 'toto@foo.com';
        $this->password = 'totobar58';
        $this->api = ApiKeyGenerator::generateKey();

        $pomm = require __DIR__.'/../.pomm_cli_bootstrap.php';
        $this->query = $pomm['db'];

        $this->query->getModel('db\Db\PublicSchema\UsersModel')
                ->createAndSave([
                    'uuid' => $this->uuid,
                    'email' => $this->email,
                    'password' => $this->password,
                    'role' => 'ROLE_USER',
                    'api' => $this->api,
        ]);
    }

    public function testApiKeyPostFramesStatusCode()
    {
        $response = $this->client->request('POST', 'frames/bulk', ['headers' => ['Content-type' => 'application/json'], 'query' => ['api_key' => $this->api], 'json' => [['project' => 'thesis', 'start' => '2015-11-06T15:01:43+01:00', 'stop' => '2015-11-06T17:01:20+01:00', 'id' => 'f9aea89ff20b427fa1d64272497503a1', 'tags' => []], ['project' => 'thesis', 'start' => '2015-12-11T16:55:20+01:00', 'stop' => '2015-12-11T16:55:23+01:00', 'id' => '3c73c4e6d9e1f49898478f07a0e759df2', 'tags' => ['ibis', 'toto', 'coucou']]]]);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testApiKeyPostFramesSatusCodeError()
    {
        try {
            $response = $this->client->request('POST', 'frames/bulk', ['headers' => ['Content-type' => 'application/json'], 'query' => ['api_key' => $this->api], 'json' => ['toto' => 'bar']]);
            $this->assertEquals(500, $response->getStatusCode());
        } catch (\GuzzleHttp\Exception\ServerException $e) {
        }
    }

    public function testApiKeyPostFramesTag()
    {
        $response = $this->client->request('POST', 'frames/bulk', ['headers' => ['Content-type' => 'application/json'], 'query' => ['api_key' => $this->api], 'json' => [['project' => 'thesis', 'start' => '2015-11-06T15:01:43+01:00', 'stop' => '2015-11-06T17:01:20+01:00', 'id' => 'f9aea89ff20b427fa1d64272497503a1', 'tags' => []], ['project' => 'thesis', 'start' => '2015-12-11T16:55:20+01:00', 'stop' => '2015-12-11T16:55:23+01:00', 'id' => '3c73c4e6d9e1f49898478f07a0e759df2', 'tags' => ['ibis', 'toto', 'coucou']]]]);

        $req = $this->query->getModel('db\Db\PublicSchema\TagModel')
                ->findWhere('tag = $*', array('toto'));

        $this->assertEquals(1, $req->count());
    }

    public function testApiKeyPostFrames()
    {
        $response = $this->client->request('POST', 'frames/bulk', ['headers' => ['Content-type' => 'application/json'], 'query' => ['api_key' => $this->api], 'json' => [['project' => 'thesis', 'start' => '2015-11-06T15:01:43+01:00', 'stop' => '2015-11-06T17:01:20+01:00', 'id' => 'f9aea89ff20b427fa1d64272497503a1', 'tags' => []], ['project' => 'thesis', 'start' => '2015-12-11T16:55:20+01:00', 'stop' => '2015-12-11T16:55:23+01:00', 'id' => '3c73c4e6d9e1f49898478f07a0e759df2', 'tags' => ['ibis', 'toto', 'coucou']]]]);

        $req = $this->query->getModel('db\Db\PublicSchema\FrameModel')
                ->findWhere('idframe = $*', array('f9aea89ff20b427fa1d64272497503a1'));

        $this->assertEquals(1, $req->count());
    }

    public function testApiKeyPostFramesProject()
    {
        $response = $this->client->request('POST', 'frames/bulk', ['headers' => ['Content-type' => 'application/json'], 'query' => ['api_key' => $this->api], 'json' => [['project' => 'thesis', 'start' => '2015-11-06T15:01:43+01:00', 'stop' => '2015-11-06T17:01:20+01:00', 'id' => 'f9aea89ff20b427fa1d64272497503a1', 'tags' => []], ['project' => 'thesis', 'start' => '2015-12-11T16:55:20+01:00', 'stop' => '2015-12-11T16:55:23+01:00', 'id' => '3c73c4e6d9e1f49898478f07a0e759df2', 'tags' => ['ibis', 'toto', 'coucou']]]]);

        $req = $this->query->getModel('db\Db\PublicSchema\ProjectModel')
                ->findWhere('name = $*', array('thesis'));

        $this->assertEquals(1, $req->count());
    }

    protected function tearDown()
    {
        $this->query->getModel('db\Db\PublicSchema\TagModel')
                ->deleteAll();
        $this->query->getModel('db\Db\PublicSchema\FrameModel')
                ->deleteAll();
        $this->query->getModel('db\Db\PublicSchema\ProjectModel')
                ->deleteAll();
        $this->query->getModel('db\Db\PublicSchema\UsersModel')
                ->deleteAll();
    }
}
