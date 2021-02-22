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

class Contato 
{
    private $tipo;
    private $contato;

    public function __construct($tipo, $contato){
        $this->setTipo($tipo);
        $this->setContato($contato);
    }

    public function setTipo($tipo){
        $this->tipo = $tipo;
    }
    
    public function setContato($contato){
        $this->contato = $contato;
    }
    
    public function getTipo(){
        return $this->tipo;
    }
    
    public function getContato(){
        return $this->contato;
    }
}

?>