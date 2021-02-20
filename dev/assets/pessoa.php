<?php
namespace App;

abstract class Pessoa  
{
    protected $user;
    protected $id;
    protected $nome;
    protected $contatos;

    protected function __construct(Usuario $user, $nome, $telefone){
        $this->setUser($user);
        $this->setNome($nome);
        $this->setContato('telefone', $telefone);
    }

    public function apresentar(){
        $dados = array('nome' => $this->nome);
        return $dados;
    }

    public function getContato($tipo){
        return $this->contatos[$tipo]->getContato();
    }
    
    public function setContato($tipo, $contato){
        $this->contatos[$tipo] = new Contato($tipo, $contato);
    }
    
    public function setNome($nome){
        $this->nome = mb_strtoupper($nome,'UTF-8');
    }
    
    abstract function getNome();
    
    public function setUser(Usuario $user){
        $this->user = $user;
    }

    public function getId(){
        return $this->id;
    }

    abstract function setId($id);
    
    abstract function getUser();
}



?>