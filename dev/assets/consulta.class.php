<?php

require_once('funcoes.php');
iniciaSession();

class Consulta  
{
   private $user;
   private $id_consulta;
   private $data_consulta;
   private $hora_inicio;
   private $hora_fim;
   private $valor;
   private $descricao;
   private $id_paciente;
   private $id_medico;
   private $estado;

    public function __construct(Usuario $user, $data_consulta, $hora_inicio, $hora_fim, $valor, $descricao, $id_paciente, $id_medico, $estado){
        $this->user = $user;
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
        $countConsultasIdInicio= getQnt('consultas', $this->user->getId());
        $countConsultasMedico= $this->getVerificaConsultaMedico(FALSE);
        $countConsultasPaciente= $this->getVerificaConsultaPaciente(FALSE);
        $msg = '';
        
        if ($countConsultasMedico == 0) {
            if ($countConsultasPaciente == 0) {
                $sql = 'INSERT INTO consultas(id_user, data_consulta, hora_inicio, hora_fim, valor, descricao, id_paciente, id_medico, estado) values(:id_user, :data_consulta, :hora_inicio, :hora_fim, :valor, :descricao, :id_paciente, :id_medico, :estado);';
                $stmt = preparaComando($sql);
                $bind = array(
                    ':id_user' => $this->user->getId(),
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
                
                $countConsultasIdFim= getQnt('consultas', $this->user->getId());
                
                if ($countConsultasIdInicio < $countConsultasIdFim) {
                    // echo ('Consulta cadastrada com sucesso!');
                    $msg = 'Consulta cadastrada com sucesso!';
                    // $_SESSION['msg'] = "Consulta cadastrada com sucesso!";
                    // header('location:agendamento.php?status=OK'); // Sucesso
                }else {
                    // echo ('Erro ao adicionar consulta!');
                    $msg = 'Erro ao adicionar consulta!';
                    // $_SESSION['msg'] = "Erro ao adicionar consulta!";
                    // header('location:agendamento.php?status=ERRO');
                }
            }else {
                // echo ('Este horário já possui outra consulta agendada para este paciente!');
                $msg = 'Este horário já possui outra consulta agendada para este paciente!';
                // $_SESSION['msg'] = "Este horário já possui outra consulta agendada para este paciente!";
                // header('location:agendamento.php?status=ERRO');
            }
        }else {
            // echo ('Este horário já possui outra consulta agendada para este médico!');
            $msg = 'Este horário já possui outra consulta agendada para este médico!';
            // $_SESSION['msg'] = "Este horário já possui outra consulta agendada para este médico!";
            // header('location:agendamento.php?status=ERRO');
        }   
        return $msg;
    }
    
    public function getVerificaConsultaMedico($op){

        if ($op == TRUE) {
            $sql = 'SELECT COUNT(*) AS qntConsulta FROM consultas WHERE id_user = :id_user and id_medico = :id_medico and data_consulta = :data_consulta and id_consulta != :id_consulta and ((hora_inicio <= :hora_inicio and hora_fim > :hora_inicio) or (hora_inicio >= :hora_inicio and hora_inicio < :hora_fim and hora_fim > :hora_inicio));';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->user->getId(),
                ':id_medico' => $this->id_medico,
                ':id_consulta' => $this->id_consulta,
                ':hora_inicio' => $this->hora_inicio,
                ':hora_fim' => $this->hora_fim,
                ':data_consulta' => $this->data_consulta
            );
        }else {
            $sql = 'SELECT COUNT(*) AS qntConsulta FROM consultas WHERE id_user = :id_user and id_medico = :id_medico and data_consulta = :data_consulta and ((hora_inicio <= :hora_inicio and hora_fim > :hora_inicio) or (hora_inicio >= :hora_inicio and hora_inicio < :hora_fim and hora_fim > :hora_inicio));';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->user->getId(),
                ':id_medico' => $this->id_medico,
                ':hora_inicio' => $this->hora_inicio,
                ':hora_fim' => $this->hora_fim,
                ':data_consulta' => $this->data_consulta
            );
        }
        $stmt = bindExecute($stmt, $bind);
        return $stmt->fetch(PDO::FETCH_ASSOC)['qntConsulta'];
    }
    
    public function getVerificaConsultaPaciente($op){
        if ($op == TRUE) {
            $sql = 'SELECT COUNT(*) AS qntConsulta FROM consultas WHERE id_user = :id_user and id_paciente = :id_paciente and data_consulta = :data_consulta and id_consulta != :id_consulta and ((hora_inicio <= :hora_inicio and hora_fim > :hora_inicio) or (hora_inicio >= :hora_inicio and hora_inicio < :hora_fim and hora_fim > :hora_inicio));';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->user->getId(),
                ':id_paciente' => $this->id_paciente,
                ':id_consulta' => $this->id_consulta,
                ':hora_inicio' => $this->hora_inicio,
                ':hora_fim' => $this->hora_fim,
                ':data_consulta' => $this->data_consulta
            );
        }else {
            $sql = 'SELECT COUNT(*) AS qntConsulta FROM consultas WHERE id_user = :id_user and id_paciente = :id_paciente and data_consulta = :data_consulta and ((hora_inicio <= :hora_inicio and hora_fim > :hora_inicio) or (hora_inicio >= :hora_inicio and hora_inicio < :hora_fim and hora_fim > :hora_inicio));';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->user->getId(),
                ':id_paciente' => $this->id_paciente,
                ':hora_inicio' => $this->hora_inicio,
                ':hora_fim' => $this->hora_fim,
                ':data_consulta' => $this->data_consulta
            );
        }
            $stmt = bindExecute($stmt, $bind);
        return $stmt->fetch(PDO::FETCH_ASSOC)['qntConsulta'];
    }

    public function setIdConsulta($id){
        $this->id_consulta = $id;
    }

    public function setUser(Usuario $user){
        $this->user = $user;
    }

    public function getUser(){
        return $this->user;
    }
    
    public function setAlteraConsulta($id_consulta){
        $this->setIdConsulta($id_consulta);
        $countConsultasMedico= $this->getVerificaConsultaMedico(TRUE);
        $countConsultasPaciente= $this->getVerificaConsultaPaciente(TRUE);
        $msg = '';
        
        if ($countConsultasMedico == 0) {
            if ($countConsultasPaciente == 0) {
                $sql = 'UPDATE consultas SET data_consulta = :data_consulta, hora_inicio = :hora_inicio, hora_fim = :hora_fim, valor = :valor, descricao = :descricao, id_paciente = :id_paciente, id_medico = :id_medico, estado = :estado WHERE id_user = :id_user AND id_consulta = :id_consulta;';
                $stmt = preparaComando($sql);
                $bind = array(
                    ':id_user' => $this->user->getId(),
                    ':id_consulta' => $this->id_consulta,
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
                
                if( $stmt->rowCount() > 0 ) {
                    // echo ('Consulta atualizada com sucesso!');
                    $msg = 'Consulta atualizada com sucesso!';
                    // $_SESSION['msg'] = "Consulta atualizada com sucesso!";
                    // header('location:agendamento.php?status=OK');
                } else {
                    // echo ('Não foi possível atualizar a consulta!');
                    $msg = 'Não foi possível atualizar a consulta!';
                    // $_SESSION['msg'] = "Não foi possível atualizar a consulta!";
                    // header('location:agendamento.php?status=ERRO');
                }
            }else {
                // echo ('Este horário já possui outra consulta agendada para este paciente!');
                $msg = 'Este horário já possui outra consulta agendada para este paciente!';
                // $_SESSION['msg'] = "Este horário já possui outra consulta agendada para este paciente!";
                // header('location:agendamento.php?status=ERRO');
            }
        }else {
            // echo ('Este horário já possui outra consulta agendada para este médico!');
            $msg = 'Este horário já possui outra consulta agendada para este médico!';
            // $_SESSION['msg'] = "Este horário já possui outra consulta agendada para este médico!";
            // header('location:agendamento.php?status=ERRO');
        }   
        return $msg;
    }
}
?>