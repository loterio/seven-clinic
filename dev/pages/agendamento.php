<?php

require_once('../assets/funcoes.php');
iniciaSession();

if (isset($_SESSION['status']) and $_SESSION['status'] == 'LOGADO') {
    $usuario = new Usuario($_SESSION['email']);
    $usuario->setId($_SESSION['id']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('agendamento.html');
        if (isset($_SESSION['id'])) {
            $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
            $filtro = isset($_GET['filtro']) ? $_GET['filtro'] :  '';
            $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
            $data = isset($_GET['data']) ? $_GET['data'] : '';
            $exclui = isset($_GET['exclui']) ? $_GET['exclui'] : '';
            if ($exclui == 'exclui') {
                header('location:agendamento.php');
            }else {
                $agenda = apresentaAgenda($busca, $data, $filtro, $pesquisa);
                if ($filtro == 'P') {
                    $pagina = str_replace('{op1}', '', $pagina);
                    $pagina = str_replace('{opP}', 'selected', $pagina);
                    $pagina = str_replace('{opM}', '', $pagina);
                    $pagina = str_replace('{opD}', '', $pagina);
                    $pagina = str_replace('{display}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_hidden}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_busca}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_data}', 'style="display: none"', $pagina);
                }else if ($filtro == 'M') {
                    $pagina = str_replace('{op1}', '', $pagina);
                    $pagina = str_replace('{opP}', '', $pagina);
                    $pagina = str_replace('{opM}', 'selected', $pagina);
                    $pagina = str_replace('{opD}', '', $pagina);
                    $pagina = str_replace('{display}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_hidden}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_busca}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_data}', 'style="display: none"', $pagina);
                }else if ($filtro == 'D') {
                    $pagina = str_replace('{op1}', '', $pagina);
                    $pagina = str_replace('{opP}', '', $pagina);
                    $pagina = str_replace('{opM}', '', $pagina);
                    $pagina = str_replace('{opD}', 'selected', $pagina);
                    $pagina = str_replace('{display}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_hidden}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_busca}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_data}', 'style="display: inline"', $pagina);
                }else {
                    $pagina = str_replace('{op1}', 'selected', $pagina);
                    $pagina = str_replace('{opP}', '', $pagina);
                    $pagina = str_replace('{opM}', '', $pagina);
                    $pagina = str_replace('{opD}', '', $pagina);
                    $pagina = str_replace('{display}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_hidden}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_busca}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_data}', 'style="display: none"', $pagina);
                }
                // $pagina = str_replace('{filtro}', $filtro, $pagina);
                $pagina = str_replace('{busca}', $busca, $pagina);
                $pagina = str_replace('{data}', $data, $pagina);
                $pagina = str_replace('{msg}', $agenda, $pagina);

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
                    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
                    $crm = isset($_POST['crm']) ? $_POST['crm'] : '';
                    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
                    $especializacao = isset($_POST['especializacao']) ? $_POST['especializacao'] : '';
         
                    $medico = new Medico($usuario, $cmr, $nome, $telefone, $especializacao);
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

                    $consulta = new Consulta($usuario, $data, $hora_inicio, $hora_final, $valor, $descricao, $paciente, $medico, 0);
                    $dadosMed = obtemMedicoPeloId($medico);
                    $medico = new Medico($usuario, $dadosMed['CRM'], $dadosMed['nome'], $dadosMed['telefone'], $dadosMed['especializacao']);
                    $medico->setId($medico->getId());
                    $consulta->setAddMedico($medico);
                    $dadosPac = obtemPacientePeloId($paciente);
                    $paciente = new Paciente($usuario, $dadosPac['nome'], $dadosPac['CPF'], $dadosPac['altura'], $dadosPac['peso'], $dadosPac['data_nascimento'], $dadosPac['email'], $dadosPac['telefone'], $dadosPac['endereco'], $dadosPac['cidade'], $dadosPac['observacoes']);
                    $paciente->setId($paciente->getId());
                    $consulta->setAddPaciente($paciente);
                    
                    $consulta->setAddConsulta();

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