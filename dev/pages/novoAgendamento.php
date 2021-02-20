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
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $pagina = file_get_contents('novoAgendamento.html');
      if (isset($_SESSION['id'])) {
        if (isset($_GET['link'])) {
          $pagina = str_replace('{link}', $_GET['link'], $pagina);
        }else {
          $pagina = str_replace('{link}', 'agendamento', $pagina);
        }
        $pagina = str_replace('{op-pacientes}', buscaPacientes(), $pagina);
        $pagina = str_replace('{op-medicos}', buscaMedicos(), $pagina);
        // $pagina = str_replace('{data}', $data, $pagina);
        // $pagina = str_replace('{msg}', $agenda, $pagina);
        
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
        // $pagina = str_replace('{filtro}', $filtro, $pagina);
      }
    }else {
    echo("Função indísponível!");
  }
}else {
  header('location:sair.php');
}

?>