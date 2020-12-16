<?php

require_once('relatorio.class.php');
require_once('funcoes.php');
iniciaSession();

class RelatorioPaciente extends Relatorio
{
    protected $id_paciente;

    public function __construct(Usuario $user,$dataInicio, $dataFim, $id_paciente){
        parent::__construct($user,$dataInicio, $dataFim);
        $this->id_paciente = $id_paciente;
    }

    public function geraRelatorio(){
        // select o valor de todas as consultas concluidas por este medico com data entre a inicial e a data final e que sejam deste usuario
        // SELECT SUM(valor) as valorTotal from consultas where id_paciente = 1 AND id_user = 1 AND estado = 1 AND data_consulta >= '2020-10-13' AND data_consulta <= '2020-11-13';
        $sql = 'SELECT SUM(valor) as valorTotal from consultas where id_paciente = :id_paciente AND id_user = :id_user AND estado = 1 AND data_consulta >= :dataInicio AND data_consulta <= :dataFim;';
        $stmt = preparaComando($sql);
        $bind = array(
            ':id_user' => $this->user->getId(),
            ':id_paciente' => $this->id_paciente,
            ':dataInicio' => $this->dataInicio,
            ':dataFim' => $this->dataFim
        );
        $stmt = bindExecute($stmt, $bind);
        $valor = $stmt->fetch(PDO::FETCH_ASSOC)['valorTotal'];
        if ($valor == NULL) {
            $valor = 0;
        }
        return $valor;
    }
}
