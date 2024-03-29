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

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('login.html');
        if (isset($_GET['status']) and $_GET['status'] == 'ERRO') {
            // Recebe o 'msg', pega os valores do session e substitui
            if (isset($_SESSION['email'])) {
                $pagina = str_replace('{email}', $_SESSION['email'], $pagina);
            }else {
                $pagina = str_replace('{email}', '', $pagina);
            }
            if (isset($_SESSION['msg'])) {
                $pagina = str_replace('{msg}', 'alert("'.$_SESSION['msg'].'");', $pagina);
            }else {
                $pagina = str_replace('{msg}', '', $pagina);
            }
        }else {
            // Não recebe 'msg', limpa o {msg} e os valores dos inputs

            $pagina = str_replace('{msg}', '', $pagina);
            $pagina = str_replace('{email}', '', $pagina);
        }
        print($pagina);
    }elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['email'] and $_POST['senha']) {
            $email = mb_strtolower($_POST['email'],'UTF-8');
            $senha = $_POST['senha'];

            $sql = 'SELECT COUNT(*) as qtd FROM usuarios WHERE email = :email AND senha = :senha';
            $stmt = preparaComando($sql);

            
            // -----CRIPTOGRAFIA DA SENHA------------------
            $senha_cript=hash('sha512',$senha);
            // --------------------------------------------
            

            $bind = array(
                ':email' => $email,
                ':senha' => $senha_cript
            );
            $stmt = bindExecute($stmt, $bind);
            $linha = $stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($linha);
            if ($linha['qtd'] == 1) {
                $sql = 'SELECT * FROM usuarios WHERE email = :email';
                $exec = preparaComando($sql);
                $bind = array(
                    ':email' => $email
                );
                $exec = bindExecute($exec, $bind);
                $linha = $exec->fetch(PDO::FETCH_ASSOC);
                limpaSession();
                iniciaSession();
                $_SESSION['status'] = 'LOGADO';
                $_SESSION['msg'] = 'Login efetuado com sucesso!';
                $_SESSION['id'] = $linha['id'];
                $_SESSION['nome'] = $linha['nome'];
                $_SESSION['email'] = $linha['email'];
                header('location:agendamento.php');
            }else {
                $_SESSION['msg'] = "Email e/ou senha inválidos!";
                $_SESSION['nome'] = $nome;
                $_SESSION['email'] = $email;
                header('location:login.php?status=ERRO');
            }



        }else {
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $_SESSION['msg'] = "Preencha todos os campos!";
            $_SESSION['email'] = $email;
            header('location:login.php?status=ERRO');

        }
    }


?>