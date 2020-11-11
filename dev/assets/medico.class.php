<?php

require_once('funcoes.php');
iniciaSession();

class Medico
{
    private $id_user;
    private $id_medico;
    private $CRM;
    private $nome; 
    private $telefone;
    private $especializacao;
    
    public function __construct($id_user, $CRM, $nome, $telefone, $especializacao){
        $this->id_user = $id_user;
        $this->setCRM($CRM);
        $this->setNome($nome);
        $this->telefone = $telefone;
        $this->setEspecializacao($especializacao);
    }
    
    public function setEspecializacao($especializacao){
        $this->especializacao = mb_strtoupper($especializacao,'UTF-8');
    }
    
    public function setNome($nome){
        $this->nome = mb_strtoupper($nome,'UTF-8');
    }
    
    public function setCRM($CRM){
        $this->CRM = mb_strtoupper($CRM,'UTF-8');
    }
    
    public function getVerificaMedicosCRM($op){
        if ($op == TRUE) {
            $sql = 'SELECT COUNT(*) AS medicosCrm FROM medicos WHERE id_user = :id_user AND CRM = :CRM AND id_medico != :id_medico;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->id_user,
                ':CRM' => $this->CRM,
                ':id_medico' => $this->id_medico
            );
        }else{
            $sql = 'SELECT COUNT(*) AS medicosCrm FROM medicos WHERE id_user = :id_user AND CRM = :CRM;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->id_user,
                ':CRM' => $this->CRM
            );
        }
        $stmt = bindExecute($stmt, $bind);
        return $stmt->fetch(PDO::FETCH_ASSOC)['medicosCrm'];
    }
    
    public function setAddMedico(){
        $countMedicosIdInicio= getQnt('medicos', $this->id_user);
        $countMedicosCrm= $this->getVerificaMedicosCRM(FALSE);
        $msg = '';
        
        if ($countMedicosCrm == 0) {  
            $sql = 'INSERT INTO medicos(id_user, nome, CRM, telefone, especializacao) values(:id_user, :nome, :CRM, :telefone, :especializacao);';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->id_user,
                ':nome' => $this->nome,
                ':CRM' => $this->CRM,
                ':telefone' => $this->telefone,
                ':especializacao' => $this->especializacao
            );
            $stmt = bindExecute($stmt, $bind);
            
            $countMedicosIdFim= getQnt('medicos', $this->id_user);
            
            if ($countMedicosIdInicio < $countMedicosIdFim) {
                $this->setIdMedico($this->getIdMedico());
                // echo ('Médico cadastrado com sucesso!');
                $msg = 'Médico cadastrado com sucesso!';
                // $_SESSION['msg'] = "Médico cadastrado com sucesso!";
                // header('location:agendamento.php?status=OK'); // Sucesso
            }else {
                // echo ('Erro ao adicionar médico!');
                $msg = 'Erro ao adicionar médico!';
                // $_SESSION['msg'] = "Erro ao adicionar médico!";
                // header('location:agendamento.php?status=ERRO');
            }
        }else {
            // echo ('Este CRM já está cadastrado!');
            $msg = 'Este CRM já está cadastrado!';
            // $_SESSION['msg'] = "Este CRM já está cadastrado!";
            // header('location:agendamento.php?status=ERRO'); // CRM ja existe
        }  
        return $msg; 
    }

    public function setIdMedico($id){
        $this->id_medico = $id;
    }

    public function getIdMedico(){
        $sql = 'SELECT id_medico FROM medicos WHERE id_user = :id_user AND CRM = :CRM;';
        $stmt = preparaComando($sql);
        $bind = array(
            ':id_user' => $this->id_user,
            ':CRM' => $this->CRM
        );
        $stmt = bindExecute($stmt, $bind);
        return $stmt->fetch(PDO::FETCH_ASSOC)['id_medico'];
    }

    public function setAlteraMedico($id_medico){
        $this->setIdMedico($id_medico);
        $countMedicosCrm= $this->getVerificaMedicosCRM(TRUE);
        $msg = '';

        if ($countMedicosCrm == 0) {
            $sql = 'UPDATE medicos SET CRM = :CRM, nome = :nome, telefone = :telefone, especializacao = :especializacao WHERE id_user = :id_user AND id_medico = :id_medico;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->id_user,
                ':id_medico' => $this->id_medico,
                ':nome' => $this->nome,
                ':CRM' => $this->CRM,
                ':telefone' => $this->telefone,
                ':especializacao' => $this->especializacao
            );
            $stmt = bindExecute($stmt, $bind);
            
            if( $stmt->rowCount() > 0 ) {
                // echo ('Médico atualizado com sucesso!');
                $msg = 'Médico atualizado com sucesso!';
                // $_SESSION['msg'] = "Médico atualizado com sucesso!";
                // header('location:agendamento.php?status=OK');
            } else {
                // echo ('Não foi possível atualizar o médico!');
                $msg = 'Não foi possível atualizar o médico!';
                // $_SESSION['msg'] = "Não foi possível atualizar o médico!";
                // header('location:agendamento.php?status=ERRO');
            }
        }else {
            // echo ('Este CRM já está cadastrado!');
            $msg = 'Este CRM já está cadastrado!';
            // $_SESSION['msg'] = "Este CRM já está cadastrado!";
            // header('location:agendamento.php?status=ERRO'); // CRM ja existe
        }  
        return $msg; 
        // $id_user, $id_medico, $CRM, $nome, $telefone, $especializacao
        // $sql = 'SELECT COUNT(*) AS medicosCrm FROM medicos WHERE id_user = :id_user AND CRM = :CRM; AND id_medico != :id_medico;';
    }
}   
// 
// 
// 

    ?>