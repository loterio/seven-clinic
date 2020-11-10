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
        $this->nome = mb_strtoupper($nome,'UTF-8');
        $this->CPF = $CPF;
        $this->altura = $altura;
        $this->peso = $peso;
        $this->data_nascimento = $data_nascimento;
        $this->email = mb_strtolower($email,'UTF-8');
        $this->telefone = $telefone;
        $this->endereco = ucwords(mb_strtolower($endereco,'UTF-8'));
        $this->cidade = mb_strtoupper($cidade,'UTF-8');
        $this->observacoes = $observacoes;
    }
    
    public function getVerificaCPF(){
        $sql = 'SELECT COUNT(*) AS pacientesCpf FROM pacientes WHERE id_user = :id_user AND CPF = :CPF;';
        $stmt = preparaComando($sql);
        $bind = array(
            ':id_user' => $this->id_user,
            ':CPF' => $this->CPF
        );
        $stmt = bindExecute($stmt, $bind);
        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $countPacientesCpf = $linha['pacientesCpf'];
        }
        return $countPacientesCpf;
    }

    public function setAddPaciente(){
        $countPacientesIdInicio= getQnt('pacientes', $this->id_user);
        $countPacientesCpf= $this->getVerificaCPF();
        
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

            // echo($countPacientesIdInicio);
            // echo($countPacientesIdFim);
            // echo($countPacientesCrm);

            if ($countPacientesIdInicio < $countPacientesIdFim) {
                echo("Paciente cadastrado com sucesso!");
                // $_SESSION['msg'] = "Paciente cadastrado com sucesso!";
                // header('location:agendamento.php?status=OK');
            }else {
                echo("Erro ao adicionar paciente!");
                // $_SESSION['msg'] = "Erro ao adicionar paciente!";
                // header('location:agendamento.php?status=ERRO');
            }
        }else {
            echo("Este CPF já está cadastrado!");
            // $_SESSION['msg'] = "Este CPF já está cadastrado!";
            // header('location:agendamento.php?status=ERRO');
        }
        
        
        
        
        // $sql = 'INSERT INTO pacientes(id_user, nome, CPF, altura, peso, data_nascimento, email, telefone, endereco, cidade, observacoes) values(:id_user, :nome, :CPF, :altura, :peso, :data_nascimento, :email, :telefone, :endereco, :cidade, :observacoes);';
        // $stmt = preparaComando($sql);
        // $bind = array(
            //     ':id_user' => $_SESSION['id'],
            //     ':nome' => $nome,
            //     ':CPF' => $cpf,
            //     ':altura' => $altura,
            //     ':peso' => $peso,
            //     ':data_nascimento' => $nascimento,
            //     ':email' => $email,
            //     ':telefone' => $telefone,
            //     ':endereco' => $endereco,
            //     ':cidade' => $cidade,
            //     ':observacoes' => $observacoes
            // );
            // // var_dump($bind);
            // $stmt = bindExecute($stmt, $bind);
            // header('location:agendamento.php');
        }
        
        
    }
    
    

?>