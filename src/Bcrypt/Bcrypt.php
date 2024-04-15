<?php

    namespace App\Bcrypt;

    class Bcrypt{
        
        private $pass;

        public function __construct($pass)
        {
            $this->pass = $pass;

        }
        public function  createPass(){
            
            $options = [
                'cost' =>  $_ENV['bcrypt'],
            ];
            return password_hash($this->pass, PASSWORD_BCRYPT, $options);
        }
        public function  verifyPass($hash){
            return password_verify($this->pass, $hash);
        }
    }