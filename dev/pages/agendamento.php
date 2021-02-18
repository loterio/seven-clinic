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
                    $pagina = str_replace('{opT}', '', $pagina);
                    $pagina = str_replace('{opP}', 'selected', $pagina);
                    $pagina = str_replace('{opM}', '', $pagina);
                    $pagina = str_replace('{opD}', '', $pagina);
                    $pagina = str_replace('{display}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_hidden}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_todas}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_busca}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_data}', 'style="display: none"', $pagina);
                }else if ($filtro == 'M') {
                    $pagina = str_replace('{op1}', '', $pagina);
                    $pagina = str_replace('{opT}', '', $pagina);
                    $pagina = str_replace('{opP}', '', $pagina);
                    $pagina = str_replace('{opM}', 'selected', $pagina);
                    $pagina = str_replace('{opD}', '', $pagina);
                    $pagina = str_replace('{display}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_hidden}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_todas}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_busca}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_data}', 'style="display: none"', $pagina);
                }else if ($filtro == 'T') {
                    $pagina = str_replace('{op1}', '', $pagina);
                    $pagina = str_replace('{opP}', '', $pagina);
                    $pagina = str_replace('{opM}', '', $pagina);
                    $pagina = str_replace('{opT}', 'selected', $pagina);
                    $pagina = str_replace('{opD}', '', $pagina);
                    $pagina = str_replace('{display}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_hidden}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_busca}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_todas}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_data}', 'style="display: none"', $pagina);
                }else if ($filtro == 'D') {
                    $pagina = str_replace('{op1}', '', $pagina);
                    $pagina = str_replace('{opT}', '', $pagina);
                    $pagina = str_replace('{opP}', '', $pagina);
                    $pagina = str_replace('{opM}', '', $pagina);
                    $pagina = str_replace('{opD}', 'selected', $pagina);
                    $pagina = str_replace('{display}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_hidden}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_todas}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_busca}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_data}', 'style="display: inline"', $pagina);
                }else {
                    $pagina = str_replace('{op1}', 'selected', $pagina);
                    $pagina = str_replace('{opT}', '', $pagina);
                    $pagina = str_replace('{opP}', '', $pagina);
                    $pagina = str_replace('{opM}', '', $pagina);
                    $pagina = str_replace('{opD}', '', $pagina);
                    $pagina = str_replace('{display}', 'style="display: none"', $pagina);
                    $pagina = str_replace('{display_hidden}', 'style="display: inline"', $pagina);
                    $pagina = str_replace('{display_todas}', 'style="display: none"', $pagina);
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
                    adicionaMedico($usuario, 'agendamento');

                }else if ($_POST['acao'] == 'addPaciente') {
                    adicionaPaciente($usuario, 'agendamento');

                }else if ($_POST['acao'] == 'addConsulta') {
                    adicionaConsulta($usuario, 'agendamento');

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

                }else if ($_POST['acao'] == 'excluiConsulta') {
                    $id_consulta = isset($_POST['id_consulta']) ? $_POST['id_consulta'] : '';
                    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
                    $valor = isset($_POST['valor']) ? $_POST['valor'] : '';
                    $data = isset($_POST['data']) ? $_POST['data'] : '';
                    $hora_inicio = isset($_POST['horario-inicio']) ? $_POST['horario-inicio'] : '';
                    $hora_final = isset($_POST['horario-fim']) ? $_POST['horario-fim'] : '';
                    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
    
                    $consulta = new Consulta($usuario, $data, $hora_inicio, $hora_final, $valor, $descricao, $estado);
                    $consulta->setIdConsulta($id_consulta);
    
                    $consulta->setExcluiConsulta();
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