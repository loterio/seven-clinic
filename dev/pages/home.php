<?php

    require_once('../assets/funcoes.php');
    iniciaSession();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('home.html');
        if (isset($_GET['status']) and $_GET['status'] == 'OK') {
            $pagina = str_replace('{msg}', 'Bem-vindo(a) '.$_SESSION['nome'].'!', $pagina);
            // var_dump($_SESSION);
            print($pagina);
        }else {
            // $pagina = str_replace('{msg}', '', $pagina);
            header('location:sair.php');
        }
    }else{
        header('location:sair.php');
    }