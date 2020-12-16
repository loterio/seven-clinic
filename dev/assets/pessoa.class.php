<?php


abstract class Pessoa  
{
    protected $user;
    protected $nome;
    protected $contatos;

    protected function __construct(Usuario $user, $nome, $telefone){
        $this->setUser($user);
        $this->setNome($nome);
        $this->setTelefone($telefone);
    }

    abstract function getTelefone();
    
    abstract function setTelefone($telefone);
    
    abstract function setNome($nome);
    
    abstract function getNome();
    
    abstract function setUser(Usuario $user);
    
    abstract function getUser();
    
    protected function setEmail($email){
        $this->contatos[1] = new Contato('email', mb_strtolower($email,'UTF-8'));
    }

    protected function getEmail(){
        return $this->contatos[1]->getContato();
    }
}



?>