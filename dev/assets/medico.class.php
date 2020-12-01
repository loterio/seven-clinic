<?php

require_once('pessoa.class.php');
require_once('funcoes.php');
iniciaSession();

class Medico extends Pessoa
{
    private $id_medico;
    private $CRM;
    private $especializacao;
    
    public function __construct(Usuario $user, $CRM, $nome, $telefone, $especializacao){
        parent::__construct($user, $nome, $telefone);
        $this->setCRM($CRM);
        $this->setEspecializacao($especializacao);
    }
    
    public function setEspecializacao($especializacao){
        $this->especializacao = mb_strtoupper($especializacao,'UTF-8');
    }

    public function setCRM($CRM){
        $this->CRM = mb_strtoupper($CRM,'UTF-8');
    }
    
    public function getVerificaMedicosCRM($op){
        if ($op == TRUE) {
            $sql = 'SELECT COUNT(*) AS medicosCrm FROM medicos WHERE id_user = :id_user AND CRM = :CRM AND id_medico != :id_medico;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->user->getId(),
                ':CRM' => $this->CRM,
                ':id_medico' => $this->id_medico
            );
        }else{
            $sql = 'SELECT COUNT(*) AS medicosCrm FROM medicos WHERE id_user = :id_user AND CRM = :CRM;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->user->getId(),
                ':CRM' => $this->CRM
            );
        }
        $stmt = bindExecute($stmt, $bind);
        return $stmt->fetch(PDO::FETCH_ASSOC)['medicosCrm'];
    }
    
    public function setAddMedico(){
        $countMedicosIdInicio= getQnt('medicos', $this->user->getId());
        $countMedicosCrm= $this->getVerificaMedicosCRM(FALSE);
        $msg = '';
        
        if ($countMedicosCrm == 0) {  
            $sql = 'INSERT INTO medicos(id_user, nome, CRM, telefone, especializacao) values(:id_user, :nome, :CRM, :telefone, :especializacao);';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->user->getId(),
                ':nome' => $this->nome,
                ':CRM' => $this->CRM,
                ':telefone' => parent::getTelefone(),
                ':especializacao' => $this->especializacao
            );
            $stmt = bindExecute($stmt, $bind);
            
            $countMedicosIdFim= getQnt('medicos', $this->user->getId());
            
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
            ':id_user' => $this->user->getId(),
            ':CRM' => $this->CRM
        );
        $stmt = bindExecute($stmt, $bind);
        $this->setIdMedico($stmt->fetch(PDO::FETCH_ASSOC)['id_medico']);
        return $this->id_medico;
    }

    public function setAlteraMedico($id_medico){
        $this->setIdMedico($id_medico);
        $countMedicosCrm= $this->getVerificaMedicosCRM(TRUE);
        $msg = '';

        if ($countMedicosCrm == 0) {
            $sql = 'UPDATE medicos SET CRM = :CRM, nome = :nome, telefone = :telefone, especializacao = :especializacao WHERE id_user = :id_user AND id_medico = :id_medico;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->user->getId(),
                ':id_medico' => $this->id_medico,
                ':nome' => $this->nome,
                ':CRM' => $this->CRM,
                ':telefone' => parent::getTelefone(),
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
        // $user, $id_medico, $CRM, $nome, $telefone, $especializacao
        // $sql = 'SELECT COUNT(*) AS medicosCrm FROM medicos WHERE id_user = :id_user AND CRM = :CRM; AND id_medico != :id_medico;';
    }

    public function getTelefone(){
        return parent::getTelefone();
    }

    
    public function setTelefone($telefone){
        parent::setTelefone($telefone);
    }
    
    public function setNome($nome){
        parent::setNome($nome);
    }

    public function getNome(){
        return parent::getNome();
    }

    public function setUser(Usuario $user){
        parent::setUser($user);
    }
    
    public function getUser(){
        return parent::getUser();
    }
}   
// 
// 
// 

    ?>