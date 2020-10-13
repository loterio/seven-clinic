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
    }else {
        header('location:sair.php');
    }
}else {
    header('location:sair.php');
}

?>