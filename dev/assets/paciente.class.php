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
        $this->setNome($nome);
        $this->CPF = $CPF;
        $this->altura = $altura;
        $this->peso = $peso;
        $this->data_nascimento = $data_nascimento;
        $this->setEmail($email);
        $this->telefone = $telefone;
        $this->setEndereco($endereco);
        $this->setCidade($cidade);
        $this->observacoes = $observacoes;
    }
    
    public function setCidade($cidade){
        $this->cidade = mb_strtoupper($cidade,'UTF-8');
    }
    
    public function setEndereco($endereco){
        $this->endereco = ucwords(mb_strtolower($endereco,'UTF-8'));
    }
    
    public function setEmail($email){
        $this->email = mb_strtolower($email,'UTF-8');
    }
    
    public function setNome($nome){
        $this->nome = mb_strtoupper($nome,'UTF-8');
    }
    
    public function setIdPaciente($id){
        $this->id_paciente = $id;
    }
    
    public function getVerificaCPF($op){
        if ($op == TRUE) {
            $sql = 'SELECT COUNT(*) AS pacientesCpf FROM pacientes WHERE id_user = :id_user AND CPF = :CPF AND id_paciente != :id_paciente;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->id_user,
                ':id_paciente' => $this->id_paciente,
                ':CPF' => $this->CPF
            );
        }else {
            $sql = 'SELECT COUNT(*) AS pacientesCpf FROM pacientes WHERE id_user = :id_user AND CPF = :CPF;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->id_user,
                ':CPF' => $this->CPF
            );
        }
        $stmt = bindExecute($stmt, $bind);
        return $stmt->fetch(PDO::FETCH_ASSOC)['pacientesCpf'];
    }
    
    public function setAddPaciente(){
        $countPacientesIdInicio= getQnt('pacientes', $this->id_user);
        $countPacientesCpf= $this->getVerificaCPF(FALSE);
        $msg = '';
        
        if ($countPacientesCpf == 0) {  
            $sql = 'INSERT INTO pacientes(id_user, nome, CPF, altura, peso, data_nascimento, email, telefone, endereco, cidade, observacoes) values(:id_user, :nome, :CPF, :altura, :peso, :data_nascimento, :email, :telefone, :endereco, :cidade, :observacoes);';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->id_user,
                ':nome' => $this->nome,
                ':CPF' => $this->CPF,
                ':altura' => $this->altura,
                ':peso' => $this->peso,
                ':data_nascimento' => $this->data_nascimento,
                ':email' => $this->email,
                ':telefone' => $this->telefone,
                ':endereco' => $this->endereco,
                ':cidade' => $this->cidade,
                ':observacoes' => $this->observacoes
            );
            $stmt = bindExecute($stmt, $bind);
            
            $countPacientesIdFim = getQnt('pacientes', $this->id_user);
            
            if ($countPacientesIdInicio < $countPacientesIdFim) {
                $this->setIdPaciente($this->getIdPaciente());
                // echo("Paciente cadastrado com sucesso!");
                $msg = 'Paciente cadastrado com sucesso!';
                // $_SESSION['msg'] = "Paciente cadastrado com sucesso!";
                // header('location:agendamento.php?status=OK');
            }else {
                // echo("Erro ao adicionar paciente!");
                $msg = 'Erro ao adicionar paciente!';
                // $_SESSION['msg'] = "Erro ao adicionar paciente!";
                // header('location:agendamento.php?status=ERRO');
            }
        }else {
            // echo("Este CPF já está cadastrado!");
            $msg = 'Este CPF já está cadastrado!';
            // $_SESSION['msg'] = "Este CPF já está cadastrado!";
            // header('location:agendamento.php?status=ERRO');
        }
        return $msg;
    }

    public function setAlteraPaciente($id_paciente){
        $this->setIdPaciente($id_paciente);
        $countPacientesCpf= $this->getVerificaCPF(TRUE);
        $msg = '';

        if ($countPacientesCpf == 0) {
            $sql = 'UPDATE pacientes SET nome = :nome, CPF = :CPF, altura = :altura, peso = :peso, data_nascimento = :data_nascimento, email = :email, telefone = :telefone, endereco = :endereco, cidade = :cidade, observacoes = :observacoes WHERE id_user = :id_user AND id_paciente = :id_paciente;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':nome' => $this->nome,
                ':CPF' => $this->CPF,
                ':altura' => $this->altura,
                ':peso' => $this->peso,
                ':data_nascimento' => $this->data_nascimento,
                ':email' => $this->email,
                ':telefone' => $this->telefone,
                ':endereco' => $this->endereco,
                ':cidade' => $this->cidade,
                ':observacoes' => $this->observacoes,
                ':id_user' => $this->id_user,
                ':id_paciente' => $this->id_paciente
            );
            $stmt = bindExecute($stmt, $bind);

            if( $stmt->rowCount() > 0 ) {
                // echo ('Paciente atualizado com sucesso!');
                $msg = 'Paciente atualizado com sucesso!';
                // $_SESSION['msg'] = "Paciente atualizado com sucesso!";
                // header('location:agendamento.php?status=OK');
            } else {
                // echo ('Não foi possível atualizar o paciente!');
                $msg = 'Não foi possível atualizar o paciente!';
                // $_SESSION['msg'] = "Não foi possível atualizar o paciente!";
                // header('location:agendamento.php?status=ERRO');
            }
        }else {
            // echo("Este CPF já está cadastrado!");
            $msg = 'Este CPF já está cadastrado!';
            // $_SESSION['msg'] = "Este CPF já está cadastrado!";
            // header('location:agendamento.php?status=ERRO');
        }
        return $msg;



    }


    public function getIdPaciente(){
        $sql = 'SELECT id_paciente FROM pacientes WHERE id_user = :id_user AND CPF = :CPF;';
        $stmt = preparaComando($sql);
        $bind = array(
            ':id_user' => $this->id_user,
            ':CPF' => $this->CPF
        );
        $stmt = bindExecute($stmt, $bind);
        return $stmt->fetch(PDO::FETCH_ASSOC)['id_paciente'];
    }
}        
    
    

?>