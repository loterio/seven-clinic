<?php

require_once('funcoes.php');
iniciaSession();

class Consulta  
{
   private $id_user;
   private $id_consulta;
   private $data_consulta;
   private $hora_inicio;
   private $hora_fim;
   private $valor;
   private $descricao;
   private $id_paciente;
   private $id_medico;
   private $estado;

    public function __construct($id_user, $data_consulta, $hora_inicio, $hora_fim, $valor, $descricao, $id_paciente, $id_medico, $estado){
        $this->id_user = $id_user;
        $this->data_consulta = $data_consulta;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fim = $hora_fim;
        $this->valor = $valor;
        $this->descricao = $descricao;
        $this->id_paciente = $id_paciente;
        $this->id_medico = $id_medico;
        $this->estado = $estado;
   }

   public function setAddConsulta(){
    $countConsultasIdInicio= getQnt('consultas', $this->id_user);
    $countConsultasMedico= $this->getVerificaConsultaMedico();
    $countConsultasPaciente= $this->getVerificaConsultaPaciente();
    
    if ($countConsultasMedico == 0) {
        if ($countConsultasPaciente == 0) {
            $sql = 'INSERT INTO consultas(id_user, data_consulta, hora_inicio, hora_fim, valor, descricao, id_paciente, id_medico, estado) values(:id_user, :data_consulta, :hora_inicio, :hora_fim, :valor, :descricao, :id_paciente, :id_medico, :estado);';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->id_user,
                ':data_consulta' => $this->data_consulta,
                ':hora_inicio' => $this->hora_inicio,
                ':hora_fim' => $this->hora_fim,
                ':valor' => $this->valor,
                ':descricao' => $this->descricao,
                ':id_paciente' => $this->id_paciente,
                ':id_medico' => $this->id_medico,
                ':estado' => $this->estado
            );
            $stmt = bindExecute($stmt, $bind);
            
            $countConsultasIdFim= getQnt('consultas', $this->id_user);
            
            if ($countConsultasIdInicio < $countConsultasIdFim) {
                echo ('Consulta cadastrada com sucesso!');
                // $_SESSION['msg'] = "Consulta cadastrada com sucesso!";
                // header('location:agendamento.php?status=OK'); // Sucesso
            }else {
                echo ('Erro ao adicionar consulta!');
                // $_SESSION['msg'] = "Erro ao adicionar consulta!";
                // header('location:agendamento.php?status=ERRO');
            }
        }else {
            echo ('Este horário já possui outra consulta agendada para este paciente!');
            // $_SESSION['msg'] = "Este horário já possui outra consulta agendada para este paciente!";
            // header('location:agendamento.php?status=ERRO');
        }
    }else {
        echo ('Este horário já possui outra consulta agendada para este médico!');
        // $_SESSION['msg'] = "Este horário já possui outra consulta agendada para este médico!";
        // header('location:agendamento.php?status=ERRO');
    }   
   }

   public function getVerificaConsultaMedico(){
       $sql = 'SELECT COUNT(*) AS qntConsulta FROM consultas WHERE id_user = :id_user and id_medico = :id_medico and data_consulta = :data_consulta and ((hora_inicio <= :hora_inicio and hora_fim > :hora_inicio) or (hora_inicio >= :hora_inicio and hora_inicio < :hora_fim and hora_fim > :hora_inicio));';
       $stmt = preparaComando($sql);
       $bind = array(
           ':id_user' => $this->id_user,
           ':id_medico' => $this->id_medico,
           ':hora_inicio' => $this->hora_inicio,
           ':hora_fim' => $this->hora_fim,
           ':data_consulta' => $this->data_consulta,
        //    ':hora_inicio' => $this->hora_inicio,
        //    ':hora_fim' => $this->hora_fim
        );
        $stmt = bindExecute($stmt, $bind);
        return $stmt->fetch(PDO::FETCH_ASSOC)['qntConsulta'];
    }
    public function getVerificaConsultaPaciente(){
        $sql = 'SELECT COUNT(*) AS qntConsulta FROM consultas WHERE id_user = :id_user and id_paciente = :id_paciente and data_consulta = :data_consulta and ((hora_inicio <= :hora_inicio and hora_fim > :hora_inicio) or (hora_inicio >= :hora_inicio and hora_inicio < :hora_fim and hora_fim > :hora_inicio));';
        $stmt = preparaComando($sql);
        $bind = array(
            ':id_user' => $this->id_user,
            ':id_paciente' => $this->id_paciente,
            ':hora_inicio' => $this->hora_inicio,
            ':hora_fim' => $this->hora_fim,
            ':data_consulta' => $this->data_consulta,
         //    ':hora_inicio' => $this->hora_inicio,
         //    ':hora_fim' => $this->hora_fim
         );
         $stmt = bindExecute($stmt, $bind);
         return $stmt->fetch(PDO::FETCH_ASSOC)['qntConsulta'];
     }
}
// id_user = 1, id_paciente = 1, id_medico = 1,
//  hora_inicio = '07:00:00', hora_fim = '08:00:00', 
// data_consulta = '2020-11-12'

// hora_inicio >= '07:00:00' and hora_inicio <= '08:00:00'  =>> 07:05:00........
// hora_fim >= '07:00:00' and hora_fim >= '08:00:00'
// SELECT * FROM consultas WHERE hora_inicio >= :hora_inicio and hora_inicio < :hora_fim and hora_fim >= :hora_inicio and hora_fim >= :hora_fim and data_consulta = :data_consulta


// SELECT * FROM `consultas` WHERE (hora_inicio <= '07:00:00' and hora_fim > '07:00:00') or (hora_inicio >= '07:00:00' and hora_fim < '08:00:00') or (hora_inicio >= '07:00:00' and hora_fim >= '08:00:00')


// inicio <= 7 and fim > 7 

// SELECT * FROM `consultas` WHERE (hora_inicio <= '07:00:00' and hora_fim > '07:00:00') or (hora_inicio >= '07:00:00' and hora_inicio < '08:00:00' and hora_fim > '07:00:00')


// SELECT COUNT(*) FROM `consultas` WHERE (hora_inicio <= '07:00:00' and hora_fim > '07:00:00') or (hora_inicio >= '07:00:00' and hora_inicio < '08:00:00' and hora_fim > '07:00:00')

// SELECT * FROM `consultas` WHERE id_user = 1 and id_medico = 1 and data_consulta = '2020-11-12' and ((hora_inicio <= '07:00:00' and hora_fim > '07:00:00') or (hora_inicio >= '07:00:00' and hora_inicio < '08:00:00' and hora_fim > '07:00:00'))
?>