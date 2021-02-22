<?php
namespace App;

use App\Consulta;
use App\Contato;
use App\Medico;
use App\Paciente;
use App\Pessoa;
use App\Relatorio;
use App\RelatorioMedico;
use App\RelatorioPaciente;
use App\Usuario;
use PDO;

require_once('../../vendor/autoload.php');
require_once('funcoes.php');
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