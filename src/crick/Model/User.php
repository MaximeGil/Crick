<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author maxime
 */
class User {
   
   private $name;
   private $password;
   private $apiKey;
   
   public function __construct($name, $password)
   {
       $this->name = $name;
       $this->password = $password;
   } 
}
