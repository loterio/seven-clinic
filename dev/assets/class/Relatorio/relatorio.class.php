<?php
namespace Classes\Relatorio;

require_once('./funcoes.php');
iniciaSession();

abstract class Relatorio
{
    protected $user;
    protected $dataInicio;
    protected $dataFim;

    public function __construct(Usuario $user,$dataInicio, $dataFim){
        $this->user = $user;
        $this->dataInicio = $dataInicio;
        $this->dataFim = $dataFim;
    }

    abstract function geraRelatorio();

    // public function getDataInicio(){
    //     return $this->dataInicio;
    // }

    // public function getDataFim(){
    //     return $this->dataFim;
    // }
}



?>