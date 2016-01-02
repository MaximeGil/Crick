<?php

use Ramsey\Uuid\Uuid;
use crick\Security\Api\ApiKeyGenerator;

class ApiKeyTest extends PHPUnit_Framework_TestCase {

    protected $app;
    protected $client;
    protected $uuid;
    protected $email;
    protected $password;
    protected $role;
    protected $api;
    protected $query;

    protected function setUp() {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'http://localhost/crick/crick/web/index.php/api/']);

        $this->uuid = Uuid::uuid1()->toString();
        $this->email = 'toto@foo.com';
        $this->password = 'totobar58';
        $this->api = ApiKeyGenerator::generateKey();

        $pomm = require __DIR__ . '/../.pomm_cli_bootstrap.php';
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


    public function testApiKeyGetPongStatusCode() {
        $response = $this->client->request('GET', 'ping', [ 'headers' => ['Accept' => 'application/json'], 'query' => ['api_key' => $this->api],]);
        $this->assertEquals(200, $response->getStatusCode());
        echo $response->getBody();
        $this->flush();
    }

    private function flush() {

        $this->query->getModel('db\Db\PublicSchema\UsersModel')
                ->deleteByPK(['uuid' => $this->uuid]);
    }

}
