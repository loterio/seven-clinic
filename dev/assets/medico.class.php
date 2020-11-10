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
        $this->CRM = $CRM;
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->especializacao = $especializacao;
    }

    
    public function getVerificaMedicosCRM(){
        $countMedicosCrm = 0;

        $sql = 'SELECT COUNT(*) AS medicosCrm FROM medicos WHERE id_user = :id_user AND CRM = :CRM;';
        $stmt = preparaComando($sql);
        $bind = array(
            ':id_user' => $this->id_user,
            ':CRM' => $this->CRM
        );
        $stmt = bindExecute($stmt, $bind);
        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $countMedicosCrm = $linha['medicosCrm'];
        }
        return $countMedicosCrm;
    }
    
    public function setAddMedico(){
        $countMedicosIdInicio= getQnt('medicos', $this->id_user);
        $countMedicosCrm= $this->getVerificaMedicosCRM();

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
            // echo $countMedicosIdInicio;
            // echo $countMedicosIdFim;
            
            if ($countMedicosIdInicio < $countMedicosIdFim) {
                echo ('Médico cadastrado com sucesso!');
                // $_SESSION['msg'] = "Médico cadastrado com sucesso!";
                // header('location:agendamento.php?status=OK'); // Sucesso
            }else {
                echo ('Erro ao adicionar médico!');
                // $_SESSION['msg'] = "Erro ao adicionar médico!";
                // header('location:agendamento.php?status=ERRO');
            }
        }else {
            echo ('Este CRM já está cadastrado!');
            // $_SESSION['msg'] = "Este CRM já está cadastrado!";
            // header('location:agendamento.php?status=ERRO'); // CRM ja existe
        }
        
        
    }
}   

// public function getQntMedicos(){
//     $countMedicos = 0;

//     $sql = 'SELECT COUNT(*) AS countId FROM medicos WHERE id_user = :id_user;';
//     $stmt = preparaComando($sql);
//     $bind = array(
//         ':id_user' => $this->id_user
//     );
//     $stmt = bindExecute($stmt, $bind);
//     while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
//         $countMedicos = $linha['countId'];
//     }
//     return $countMedicos;
// }

// $medico = new Medico(1, 1, 'Felipe', '34343434', 'Geral');
// var_dump($medico);
// $medico->teste();
?>