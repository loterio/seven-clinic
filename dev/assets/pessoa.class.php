<?php


class Pessoa  
{
    private $user;
    private $nome;
    private $contatos;

    public function __construct(Usuario $user, $nome, $telefone){
        $this->setUser($user);
        $this->setNome($nome);
        $this->setTelefone($telefone);
    }

    public function getTelefone(){
        return $this->contatos[0]->getContato();
    }

    public function getEmail(){
        return $this->contatos[1]->getContato();
    }
    
    public function setTelefone($telefone){
        $this->contatos[0] = new Contato('telefone', $telefone);
    }

    public function setEmail($email){
        $this->contatos[1] = new Contato('email', mb_strtolower($email,'UTF-8'));
    }
    
    public function setNome($nome){
        $this->nome = mb_strtoupper($nome,'UTF-8');
    }

    public function getNome(){
        return $this->nome;
    }

    public function setUser(Usuario $user){
        $this->user = $user;
    }
    
    public function getUser(){
        return $this->user;
    }
}



?>