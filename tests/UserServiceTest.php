<?php

use crick\Service\UserService;

class UserServiceTest extends PHPUnit_Framework_TestCase
{
    protected $userInstance;
    protected $userInstance2;
    protected $userInstance3;
    protected $userInstance4;
    protected $userInstance5;

    protected function setUp()
    {
        $this->userInstance = new UserService('foo@gmail.com', 'toto58', 'Qk1MeDJCTEtZZll0WGxUa0xBbkt4cTdmb1UxNlhqR0FVVXVKRllMUU5vQ29NcTVwWXdBbUFCSjlqN1pT', 'ROLE_USER');
        $this->userInstance2 = new UserService('fooz@gmail.com', 'toto58', 'Qk1MeDJCTEtZZll0WGxUa0xBbkt4cTdmb1UxNlhqR0FVVXVKRllMUU5vQ29NcTVwWXdBbUFCSjlqN1pT', 'ROLE_USER');
        $this->userInstance3 = new UserService('foo@gmail.com', 'totoz58', 'Qk1MeDJCTEtZZll0WGxUa0xBbkt4cTdmb1UxNlhqR0FVVXVKRllMUU5vQ29NcTVwWXdBbUFCSjlqN1pT', 'ROLE_USER');
        $this->userInstance4 = new UserService('foo@gmail.com', 'toto58', 'zQk1MeDJCTEtZZll0WGxUa0xBbkt4cTdmb1UxNlhqR0FVVXVKRllMUU5vQ29NcTVwWXdBbUFCSjlqN1pT', 'ROLE_USER');
    }

    public function testUserNotNull()
    {
        $this->assertNotNull($this->userInstance);
    }

    public function testUsername()
    {
        $this->assertEquals('foo@gmail.com', $this->userInstance->getUsername());
    }

    public function testPassword()
    {
        $this->assertEquals('toto58', $this->userInstance->getPassword());
    }

    public function testApiKey()
    {
        $this->assertEquals('Qk1MeDJCTEtZZll0WGxUa0xBbkt4cTdmb1UxNlhqR0FVVXVKRllMUU5vQ29NcTVwWXdBbUFCSjlqN1pT', $this->userInstance->getApiKey());
    }

    public function testRole()
    {
        $this->assertEquals('ROLE_USER', $this->userInstance->getRoles());
    }

    public function testEqualToUserInterface()
    {
        $userInstanceClone = $this->userInstance;
        $this->assertTrue($this->userInstance->isEqualTo($userInstanceClone));
    }

    public function testNotEqualUsername()
    {
        $this->assertFalse($this->userInstance->isEqualTo($this->userInstance2));
    }

    public function testNotEqualPassword()
    {
        $this->assertFalse($this->userInstance->isEqualTo($this->userInstance3));
    }

    public function testNotEqualApiKey()
    {
        $this->assertFalse($this->userInstance->isEqualTo($this->userInstance4));
    }
}
