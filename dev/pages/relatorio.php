<?php

require_once('../assets/funcoes.php');
iniciaSession();

if (isset($_SESSION['status']) and $_SESSION['status'] == 'LOGADO') {
    $usuario = new Usuario($_SESSION['email']);
    $usuario->setId($_SESSION['id']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('relatorio.html');
        if (isset($_SESSION['id'])) {
            $busca = isset($_GET['busca']) ? $_GET['busca'] : date('Y');
            $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
            $data = isset($_GET['data']) ? $_GET['data'] : '';
            $exclui = isset($_GET['exclui']) ? $_GET['exclui'] : '';
            if ($exclui == 'exclui') {
                header('location:paciente.php');
            }else {
                $agenda = apresentaRelatorio($busca);
                $sqlUsuario = 'SELECT * FROM usuarios WHERE id = :id';
                $stmtUsuario = preparaComando($sqlUsuario);
                $bindUsuario = array(
                    ':id' => $_SESSION['id']
                );
                $stmtUsuario = bindExecute($stmtUsuario, $bindUsuario);
                $dadosUsuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

                $pagina = str_replace('{busca}', $busca, $pagina);
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
                    adicionaMedico($usuario, 'relatorio');

                }else if ($_POST['acao'] == 'addPaciente') {
                    adicionaPaciente($usuario, 'relatorio');

                }else if ($_POST['acao'] == 'addConsulta') {
                    adicionaConsulta($usuario, 'relatorio');

                }else {
                    echo("Função indísponível!");
                }
            }else {
                header('location:relatorio.php');
            }
        }else {
            header('location:relatorio.php');
        }
    }else {
        header('location:sair.php');
    }
}else {
    header('location:sair.php');
}

?>