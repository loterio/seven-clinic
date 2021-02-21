<?php

require_once('../assets/funcoes.php');
iniciaSession();

if (isset($_SESSION['status']) and $_SESSION['status'] == 'LOGADO') {
    $usuario = new Usuario($_SESSION['email']);
    $usuario->setId($_SESSION['id']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('paciente.html');
        if (isset($_SESSION['id'])) {
            $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
            $filtro = isset($_GET['filtro']) ? $_GET['filtro'] :  '';
            $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
            $data = isset($_GET['data']) ? $_GET['data'] : '';
            $exclui = isset($_GET['exclui']) ? $_GET['exclui'] : '';
            if ($exclui == 'exclui') {
                header('location:paciente.php');
            }else {
                $agenda = apresentaPaciente($busca, $filtro);
                if ($filtro == 'P') {
                    $pagina = str_replace('{op1}', '', $pagina);
                    $pagina = str_replace('{opP}', 'selected', $pagina);
                    $pagina = str_replace('{opM}', '', $pagina);
                    $pagina = str_replace('{display}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_hidden}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_busca}', 'style="display: inline"', $pagina);
                }else if ($filtro == 'M') {
                    $pagina = str_replace('{op1}', '', $pagina);
                    $pagina = str_replace('{opP}', '', $pagina);
                    $pagina = str_replace('{opM}', 'selected', $pagina);
                    $pagina = str_replace('{display}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_hidden}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_busca}', 'style="display: inline"', $pagina);
                }else {
                    $pagina = str_replace('{op1}', 'selected', $pagina);
                    $pagina = str_replace('{opP}', '', $pagina);
                    $pagina = str_replace('{opM}', '', $pagina);
                    $pagina = str_replace('{display}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_hidden}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_busca}', 'style="display: none"', $pagina);
                }
                // $pagina = str_replace('{filtro}', $filtro, $pagina);
                $sqlUsuario = 'SELECT * FROM usuarios WHERE id = :id';
                $stmtUsuario = preparaComando($sqlUsuario);
                $bindUsuario = array(
                    ':id' => $_SESSION['id']
                );
                $stmtUsuario = bindExecute($stmtUsuario, $bindUsuario);
                $dadosUsuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

                $pagina = str_replace('{busca}', $busca, $pagina);
                $pagina = str_replace('{data}', $data, $pagina);
                $pagina = str_replace('{msg}', $agenda, $pagina);
                $pagina = str_replace('{op-pacientes}', buscaPacientes(), $pagina);
                $pagina = str_replace('{op-medicos}', buscaMedicos(), $pagina);
                $pagina = str_replace('{nome}', $dadosUsuario['nome'], $pagina);
                $pagina = str_replace('{email}', $dadosUsuario['email'], $pagina);

                if (isset($_GET['status'])){
                    if ($_GET['status'] == 'ERRO' OR $_GET['status'] == 'OK' AND isset($_SESSION['msg'])) {   
                        $pagina = str_replace('{erro}', 'alert("'.$_SESSION['msg'].'");', $pagina);
                    }else {
                        $pagina = str_replace('{erro}', '', $pagina);
                    }
                }else {
                    $pagina = str_replace('{erro}', '', $pagina);
                }


                print($pagina);
            }
        }
    }else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['acao'])) {
            if (isset($_SESSION['id'])) {
                if ($_POST['acao'] == 'addMedico') {
                    adicionaMedico($usuario, 'paciente');

                }else if ($_POST['acao'] == 'addPaciente') {
                    adicionaPaciente($usuario, 'paciente');

                }else if ($_POST['acao'] == 'addConsulta') {
                    adicionaConsulta($usuario, 'paciente');

                }else if ($_POST['acao'] == 'alteraPaciente') {
                    $id_paciente = isset($_POST['id_paciente']) ? $_POST['id_paciente'] : '';
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
                    $paciente->setId($id_paciente);
                    $paciente->setAlteraPaciente();

                }else if ($_POST['acao'] == 'excluiPaciente') {
                    $id_paciente = isset($_POST['id_paciente']) ? $_POST['id_paciente'] : '';
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
                    $paciente->setExcluiPaciente();
                }else {
                    echo("Função indísponível!");
                }
            }else {
                header('location:paciente.php');
            }
        }else {
            header('location:paciente.php');
        }
    }else {
        header('location:sair.php');
    }
}else {
    header('location:sair.php');
}

?>