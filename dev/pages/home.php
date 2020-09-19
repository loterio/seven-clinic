<?php

    // require_once('../assets/funcoes.php');
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('home.html');
        if (isset($_GET['msg'])) {
            $pagina = str_replace('{msg}', '<div>'.$_GET['msg'].'</div>',$pagina);
        }else {
            $pagina = str_replace('{msg}', '', $pagina);
        }
        print($pagina);
    }