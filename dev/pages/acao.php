<?php
require_once('../assets/funcoes.php');
iniciaSession();

if (isset($_SESSION['status']) and $_SESSION['status'] == 'LOGADO') {
    $usuario = new Usuario($_SESSION['email']);
    $usuario->setId($_SESSION['id']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_POST['acao'])) {

            // else {
            //     echo("Função indísponível!");
            // }
        }else {
            header('location:agendamento.php');
        }
    }else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['acao'])) {
            if (isset($_SESSION['id'])) {
                if ($_POST['acao'] == 'addMedico') {
                    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
                    $crm = isset($_POST['crm']) ? $_POST['crm'] : '';
                    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
                    $especializacao = isset($_POST['especializacao']) ? $_POST['especializacao'] : '';
         
                    $medico = new Medico($usuario, $crm, $nome, $telefone, $especializacao);
                    $medico->setAddMedico();

                }else if ($_POST['acao'] == 'addPaciente') {
                    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
                    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
                    $altura = isset($_POST['altura']) ? $_POST['altura'] : '';
                    $peso = isset($_POST['peso']) ? $_POST['peso'] : '';
                    $nascimento = isset($_POST['nascimento']) ? $_POST['nascimento'] : '';
                    $email = isset($_POST['email']) ? $_POST['email'] : '';
                    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
                    $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : '';
                    $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : '';
                    $observacoes = isset($_POST['observacoes']) ? $_POST['observacoes'] : '';


                    $paciente = new Paciente($usuario, $nome, $cpf, $altura, $peso, $nascimento, $email, $telefone, $endereco, $cidade, $observacoes);
                    $paciente->setAddPaciente();

                }else if ($_POST['acao'] == 'addConsulta') {
                    $paciente = isset($_POST['paciente']) ? $_POST['paciente'] : '';
                    $medico = isset($_POST['medico']) ? $_POST['medico'] : '';
                    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
                    $valor = isset($_POST['valor']) ? $_POST['valor'] : '';
                    $data = isset($_POST['data']) ? $_POST['data'] : '';
                    $hora_inicio = isset($_POST['hora_inicio']) ? $_POST['hora_inicio'] : '';
                    $hora_final = isset($_POST['hora_final']) ? $_POST['hora_final'] : '';

                    $consulta = new Consulta($usuario, $data, $hora_inicio, $hora_final, $valor, $descricao, 0);
                    $dadosMed = obtemMedicoPeloId($medico);
                    $medico = new Medico($usuario, $dadosMed['CRM'], $dadosMed['nome'], $dadosMed['telefone'], $dadosMed['especializacao']);
                    $medico->setId($medico->getId());
                    $consulta->setAddMedico($medico);
                    $dadosPac = obtemPacientePeloId($paciente);
                    $paciente = new Paciente($usuario, $dadosPac['nome'], $dadosPac['CPF'], $dadosPac['altura'], $dadosPac['peso'], $dadosPac['data_nascimento'], $dadosPac['email'], $dadosPac['telefone'], $dadosPac['endereco'], $dadosPac['cidade'], $dadosPac['observacoes']);
                    $paciente->setId($paciente->getId());
                    $consulta->setAddPaciente($paciente);
                    
                    $consulta->setAddConsulta();

                }else if ($_POST['acao'] == 'alteraConsulta') {
                    $id_consulta = isset($_POST['id_consulta']) ? $_POST['id_consulta'] : '';
                    $paciente = isset($_POST['paciente']) ? $_POST['paciente'] : '';
                    $medico = isset($_POST['medico']) ? $_POST['medico'] : '';
                    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
                    $valor = isset($_POST['valor']) ? $_POST['valor'] : '';
                    $data = isset($_POST['data']) ? $_POST['data'] : '';
                    $hora_inicio = isset($_POST['horario-inicio']) ? $_POST['horario-inicio'] : '';
                    $hora_final = isset($_POST['horario-fim']) ? $_POST['horario-fim'] : '';
                    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';

                    $consulta = new Consulta($usuario, $data, $hora_inicio, $hora_final, $valor, $descricao, $estado);
                    $dadosMed = obtemMedicoPeloId($medico);
                    $medico = new Medico($usuario, $dadosMed['CRM'], $dadosMed['nome'], $dadosMed['telefone'], $dadosMed['especializacao']);
                    $medico->setId($medico->getId());
                    $consulta->setAddMedico($medico);
                    $dadosPac = obtemPacientePeloId($paciente);
                    $paciente = new Paciente($usuario, $dadosPac['nome'], $dadosPac['CPF'], $dadosPac['altura'], $dadosPac['peso'], $dadosPac['data_nascimento'], $dadosPac['email'], $dadosPac['telefone'], $dadosPac['endereco'], $dadosPac['cidade'], $dadosPac['observacoes']);
                    $paciente->setId($paciente->getId());
                    $consulta->setAddPaciente($paciente);
                    $consulta->setIdConsulta($id_consulta);
                    
                    $consulta->setAlteraConsulta();

                }else {
                    echo("Função indísponível!");
                }
            }else {
                header('location:agendamento.php');
            }
        }else {
            header('location:agendamento.php');
        }
    }else {
        header('location:sair.php');
    }
}else {
    header('location:sair.php');
}

?>