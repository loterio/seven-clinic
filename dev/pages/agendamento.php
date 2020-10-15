<?php

require_once('../assets/funcoes.php');
iniciaSession();

if (isset($_SESSION['status']) and $_SESSION['status'] == 'LOGADO') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('agendamento.html');
        if (isset($_SESSION['id'])) {
            $agenda = apresentaAgenda();
            $pagina = str_replace('{msg}', $agenda, $pagina);
            print($pagina);
        }
    }if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['acao'])) {
            if (isset($_SESSION['id'])) {
                if ($_POST['acao'] == 'addMedico') {
                    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
                    $crm = isset($_POST['crm']) ? $_POST['crm'] : '';
                    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
                    $especializacao = isset($_POST['especializacao']) ? $_POST['especializacao'] : '';
                    
                    $sql = 'INSERT INTO medicos(id_user, nome, CRM, telefone, especializacao) values(:id_user, :nome, :CRM, :telefone, :especializacao);';
                    $stmt = preparaComando($sql);
                    $bind = array(
                        ':id_user' => $_SESSION['id'],
                        ':nome' => $nome,
                        ':CRM' => $crm,
                        ':telefone' => $telefone,
                        ':especializacao' => $especializacao
                    );
                    $stmt = bindExecute($stmt, $bind);
                    header('location:agendamento.php');
                }if ($_POST['acao'] == 'addPaciente') {
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
                    
                    $sql = 'INSERT INTO pacientes(id_user, nome, CPF, altura, peso, data_nascimento, email, telefone, endereco, cidade, observacoes) values(:id_user, :nome, :CPF, :altura, :peso, :data_nascimento, :email, :telefone, :endereco, :cidade, :observacoes);';
                    $stmt = preparaComando($sql);
                    $bind = array(
                        ':id_user' => $_SESSION['id'],
                        ':nome' => $nome,
                        ':CPF' => $cpf,
                        ':altura' => $altura,
                        ':peso' => $peso,
                        ':data_nascimento' => $nascimento,
                        ':email' => $email,
                        ':telefone' => $telefone,
                        ':endereco' => $endereco,
                        ':cidade' => $cidade,
                        ':observacoes' => $observacoes
                    );
                    // var_dump($bind);
                    $stmt = bindExecute($stmt, $bind);
                    header('location:agendamento.php');
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