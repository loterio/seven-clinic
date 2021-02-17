<?php

require_once('../assets/funcoes.php');
iniciaSession();

if (isset($_SESSION['status']) and $_SESSION['status'] == 'LOGADO') {
    $usuario = new Usuario($_SESSION['email']);
    $usuario->setId($_SESSION['id']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('medico.html');
        if (isset($_SESSION['id'])) {
            $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
            $filtro = isset($_GET['filtro']) ? $_GET['filtro'] :  '';
            $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
            $data = isset($_GET['data']) ? $_GET['data'] : '';
            $exclui = isset($_GET['exclui']) ? $_GET['exclui'] : '';
            if ($exclui == 'exclui') {
                header('location:medico.php');
            }else {
                $agenda = apresentaMedico($busca, $filtro);
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
                    adicionaMedico($usuario, 'medico');

                }else if ($_POST['acao'] == 'addPaciente') {
                    adicionaPaciente($usuario, 'medico');

                }else if ($_POST['acao'] == 'addConsulta') {
                    adicionaConsulta($usuario, 'medico');

                }else if ($_POST['acao'] == 'alteraMedico') {
                    $id_medico = isset($_POST['id_medico']) ? $_POST['id_medico'] : '';
                    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
                    $crm = isset($_POST['crm']) ? $_POST['crm'] : '';
                    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
                    $especializacao = isset($_POST['especializacao']) ? $_POST['especializacao'] : '';

                    $medico = new Medico($usuario, $crm, $nome, $telefone, $especializacao);
                    $medico->setId($id_medico);

                    $medico->setAlteraMedico();

                }else if ($_POST['acao'] == 'excluiMedico') {
                    $id_medico = isset($_POST['id_medico']) ? $_POST['id_medico'] : '';
                    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
                    $crm = isset($_POST['crm']) ? $_POST['crm'] : '';
                    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
                    $especializacao = isset($_POST['especializacao']) ? $_POST['especializacao'] : '';

                    $medico = new Medico($usuario, $crm, $nome, $telefone, $especializacao);
                    // var_dump($medico);
                    $medico->setExcluiMedico();

                }else {
                    echo("Função indísponível!");
                }
            }else {
                header('location:medico.php');
            }
        }else {
            header('location:medico.php');
        }
    }else {
        header('location:sair.php');
    }
}else {
    header('location:sair.php');
}

?>