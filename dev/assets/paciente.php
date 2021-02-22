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

require_once('funcoes.php');
iniciaSession();


class Paciente extends Pessoa
{
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
        $this->setContato('email',$email);
        $this->setEndereco($endereco);
        $this->setCidade($cidade);
        $this->observacoes = $observacoes;
    }

    public function apresentar(){
        $dados = parent::apresentar();
        $dados['CPF'] = $this->CPF;
        $dados['data_nascimento'] = $this->data_nascimento;
        return $dados;
    }
    
    public function setCidade($cidade){
        $this->cidade = mb_strtoupper($cidade,'UTF-8');
    }
    
    public function setEndereco($endereco){
        $this->endereco = ucwords(mb_strtolower($endereco,'UTF-8'));
    }
    
    public function setContato($tipo, $contato){
        if ($tipo == 'email') {
            parent::setContato($tipo, mb_strtolower($contato,'UTF-8'));
        }else {
            parent::setContato($tipo, $contato);
        }
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function getVerificaCPF($op){
        if ($op == TRUE) {
            $sql = 'SELECT COUNT(*) AS pacientesCpf FROM pacientes WHERE id_user = :id_user AND CPF = :CPF AND id_paciente != :id_paciente;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id_user' => $this->user->getId(),
                ':id_paciente' => $this->id,
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
    
    public function setAddPaciente($link){
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
                ':email' => parent::getContato('email'),
                ':telefone' => parent::getContato('telefone'),
                ':endereco' => $this->endereco,
                ':cidade' => $this->cidade,
                ':observacoes' => $this->observacoes
            );
            $stmt = bindExecute($stmt, $bind);
            
            $countPacientesIdFim = getQnt('pacientes', $this->user->getId());
            
            if ($countPacientesIdInicio < $countPacientesIdFim) {
                $this->setId($this->getId());
                // echo("Paciente cadastrado com sucesso!");
                // $msg = 'Paciente cadastrado com sucesso!';
                $_SESSION['msg'] = "Paciente cadastrado com sucesso!";
                header('location:'.$link.'.php?status=OK');
            }else {
                // echo("Erro ao adicionar paciente!");
                // $msg = 'Erro ao adicionar paciente!';
                $_SESSION['msg'] = "Erro ao adicionar paciente!";
                header('location:'.$link.'.php?status=ERRO');
            }
        }else {
            // echo("Este CPF já está cadastrado!");
            // $msg = 'Este CPF já está cadastrado!';
            $_SESSION['msg'] = "Este CPF já está cadastrado!";
            header('location:'.$link.'.php?status=ERRO');
        }
        // return $msg;
    }

    public function setAlteraPaciente(){
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
                ':email' => parent::getContato('email'),
                ':telefone' => parent::getContato('telefone'),
                ':endereco' => $this->endereco,
                ':cidade' => $this->cidade,
                ':observacoes' => $this->observacoes,
                ':id_user' => $this->user->getId(),
                ':id_paciente' => $this->id
            );
            $stmt = bindExecute($stmt, $bind);

            if( $stmt->rowCount() > 0 ) {
                // echo ('Paciente atualizado com sucesso!');
                // $msg = 'Paciente atualizado com sucesso!';
                $_SESSION['msg'] = "Paciente atualizado com sucesso!";
                header('location:paciente.php?status=OK');
            } else {
                // echo ('Não foi possível atualizar o paciente!');
                // $msg = 'Não foi possível atualizar o paciente!';
                $_SESSION['msg'] = "Não foi possível atualizar o paciente!";
                header('location:paciente.php?status=ERRO');
            }
        }else {
            // echo("Este CPF já está cadastrado!");
            // $msg = 'Este CPF já está cadastrado!';
            $_SESSION['msg'] = "Este CPF já está cadastrado!";
            header('location:paciente.php?status=ERRO');
        }
        return $msg;
    }

    public function getId(){
        $sql = 'SELECT id_paciente FROM pacientes WHERE id_user = :id_user AND CPF = :CPF;';
        $stmt = preparaComando($sql);
        $bind = array(
            ':id_user' => $this->user->getId(),
            ':CPF' => $this->CPF
        );
        $stmt = bindExecute($stmt, $bind);
        $this->setId($stmt->fetch(PDO::FETCH_ASSOC)['id_paciente']);
        return $this->id;
    }

    public function getNome(){
        return parent::$nome;
    }
    
    public function getUser(){
        return parent::$user;
    }

    public function setExcluiPaciente(){
        $countConsultasIdInicio= getQnt('pacientes', $this->user->getId());
        $msg = '';
        
        $sql = 'DELETE FROM pacientes WHERE id_user = :id_user AND CPF = :CPF';
        $stmt = preparaComando($sql);
        $bind = array(
            ':id_user' => $this->user->getId(),
            ':CPF' => $this->CPF
        );
        $stmt = bindExecute($stmt, $bind);
        
        $countConsultasIdFim= getQnt('pacientes', $this->user->getId());

        if ($countConsultasIdInicio > $countConsultasIdFim) {
            // echo ('Paciente excluido com sucesso!');
            // $msg = 'Paciente excluido com sucesso!';
            $_SESSION['msg'] = "Paciente excluido com sucesso!";
            header('location:paciente.php?status=OK'); // Sucesso
        }else {
            // echo ('Erro ao excluir paciente!');
            // $msg = 'Erro ao excluir paciente!';
            $_SESSION['msg'] = "Erro ao excluir paciente!";
            header('location:paciente.php?status=ERRO');
        }
    }
}        
    
    

?>