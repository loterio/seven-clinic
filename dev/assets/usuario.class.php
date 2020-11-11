<?php

require_once('funcoes.php');
iniciaSession();

class Usuario  
{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $confSenha;

    public function __construct($email){
        $this->setEmail($email);
    }

    public function setEmail($email){
        $this->email = mb_strtolower($email,'UTF-8');
    }
}


?>