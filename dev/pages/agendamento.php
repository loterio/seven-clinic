<?php

require_once('../assets/funcoes.php');
iniciaSession();

if (isset($_SESSION['status']) and $_SESSION['status'] == 'LOGADO') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('agendamento.html');
        if (isset($_SESSION['id'])) {
            $busca = isset($_POST['busca']) ? $_POST['busca'] : NULL;
            $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : NULL;
            $pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : NULL;
            $agenda = apresentaAgenda($busca, $filtro, $pesquisa);
            $pagina = str_replace('{msg}', $agenda, $pagina);
            print($pagina);
        }
    }else {
        header('location:sair.php');
    }
}else {
    header('location:sair.php');
}

?>