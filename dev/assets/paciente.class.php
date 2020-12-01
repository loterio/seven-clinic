<?php

require_once('pessoa.class.php');
require_once('funcoes.php');
iniciaSession();


class Paciente extends Pessoa
{
    private $id_paciente;
    private $CPF;
    private $altura;
    private $peso;
    private $data_nascimento;
    private $endereco;
    private $cidade;
    private $observacoes;
    
    public function __construct(Usuario $user, $nome, $CPF, $altura, $peso, $data_nascimento, $email, $telefone, $endereco, $cidade, $observacoes){
        parent::__construct($user, $nome, $telefone);
        $this->CPF = $CPF;
        $this->altura = $altura;
        $this->peso = $peso;
        $this->data_nascimento = $data_nascimento;
        $this->setEmail($email);
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
        parent::setEmail($email);
    }

    public function getEmail(){
        return parent::getEmail();
    }
    
    public function setIdPaciente($id){
        $this->id_paciente = $id;
    }
    
    public function getVerificaCPF($op){
        if ($op == TRUE) {
            $sql = 'SELECT COUNT(*) AS pacientesCpf FROM pacientes WHERE id_user = :id_user AND CPF = :CPF AND id_paciente != :id_paciente;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->user->getId(),
                ':id_paciente' => $this->id_paciente,
                ':CPF' => $this->CPF
            );
        }else {
            $sql = 'SELECT COUNT(*) AS pacientesCpf FROM pacientes WHERE id_user = :id_user AND CPF = :CPF;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->user->getId(),
                ':CPF' => $this->CPF
            );
        }
        $stmt = bindExecute($stmt, $bind);
        return $stmt->fetch(PDO::FETCH_ASSOC)['pacientesCpf'];
    }
    
    public function setAddPaciente(){
        $countPacientesIdInicio= getQnt('pacientes', $this->user->getId());
        $countPacientesCpf= $this->getVerificaCPF(FALSE);
        $msg = '';
        
        if ($countPacientesCpf == 0) {  
            $sql = 'INSERT INTO pacientes(id_user, nome, CPF, altura, peso, data_nascimento, email, telefone, endereco, cidade, observacoes) values(:id_user, :nome, :CPF, :altura, :peso, :data_nascimento, :email, :telefone, :endereco, :cidade, :observacoes);';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->user->getId(),
                ':nome' => $this->nome,
                ':CPF' => $this->CPF,
                ':altura' => $this->altura,
                ':peso' => $this->peso,
                ':data_nascimento' => $this->data_nascimento,
                ':email' => $this->getEmail(),
                ':telefone' => parent::getTelefone(),
                ':endereco' => $this->endereco,
                ':cidade' => $this->cidade,
                ':observacoes' => $this->observacoes
            );
            $stmt = bindExecute($stmt, $bind);
            
            $countPacientesIdFim = getQnt('pacientes', $this->user->getId());
            
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
                ':email' => $this->getEmail(),
                ':telefone' => parent::getTelefone(),
                ':endereco' => $this->endereco,
                ':cidade' => $this->cidade,
                ':observacoes' => $this->observacoes,
                ':id_user' => $this->user->getId(),
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
            ':id_user' => $this->user->getId(),
            ':CPF' => $this->CPF
        );
        $stmt = bindExecute($stmt, $bind);
        $this->setIdPaciente($stmt->fetch(PDO::FETCH_ASSOC)['id_paciente']);
        return $this->id_paciente;
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
    
    

?>