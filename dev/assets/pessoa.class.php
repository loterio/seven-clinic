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

    public function getTelefone(){
        return $this->contatos[0]->getContato();
    }
    
    public function setTelefone($telefone){
        $this->contatos[0] = new Contato('telefone', $telefone);
    }
    
    public function setNome($nome){
        $this->nome = mb_strtoupper($nome,'UTF-8');
    }
    
    abstract function getNome();
    
    public function setUser(Usuario $user){
        $this->user = $user;
    }
    
    abstract function getUser();
    
    protected function setEmail($email){
        $this->contatos[1] = new Contato('email', mb_strtolower($email,'UTF-8'));
    }

    protected function getEmail(){
        return $this->contatos[1]->getContato();
    }
}



?>