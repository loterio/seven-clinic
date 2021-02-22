<?php

use App\Consulta;
use App\Contato;
use App\Medico;
use App\Paciente;
use App\Pessoa;
use App\Relatorio;
use App\Usuario;

require_once('../../vendor/autoload.php');
require_once('../assets/funcoes.php');
iniciaSession();

if (isset($_SESSION['status']) and $_SESSION['status'] == 'LOGADO') {
  $usuario = new Usuario($_SESSION['email']);
  $usuario->setId($_SESSION['id']);
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $pagina = file_get_contents('novoPaciente.html');
    if (isset($_GET['link'])) {
      $pagina = str_replace('{link}', $_GET['link'], $pagina);
    }else {
      $pagina = str_replace('{link}', 'agendamento', $pagina);
    }
    print($pagina);
    // $pagina = str_replace('{filtro}', $filtro, $pagina);
  }else {
    echo("Função indísponível!");
  }
}else {
  header('location:sair.php');
}
?>