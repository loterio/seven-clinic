<?php

require_once('funcoes.php');
iniciaSession();


class Paciente  
{
    private $id_user;
    private $id_paciente;
    private $nome;
    private $CPF;
    private $altura;
    private $peso;
    private $data_nascimento;
    private $email;
    private $telefone;
    private $endereco;
    private $cidade;
    private $observacoes;

    public function __construct($id_user, $nome, $CPF, $altura, $peso, $data_nascimento, $email, $telefone, $endereco, $cidade, $observacoes){
        $this->id_user = $id_user;
        $this->nome = $nome;
        $this->CPF = $CPF;
        $this->altura = $altura;
        $this->peso = $peso;
        $this->data_nascimento = $data_nascimento;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->endereco = $endereco;
        $this->cidade = $cidade;
        $this->observacoes = $observacoes;
    }

    
}



?>