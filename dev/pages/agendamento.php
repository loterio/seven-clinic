<?php

require_once('../assets/funcoes.php');
iniciaSession();

if (isset($_SESSION['status']) and $_SESSION['status'] == 'LOGADO') {
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
                print($pagina);
            }
        }
    }else {
        header('location:sair.php');
    }
}else {
    header('location:sair.php');
}

?>