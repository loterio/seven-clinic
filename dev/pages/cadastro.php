<?php

    require_once('../assets/funcoes.php');
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('cadastro.html');
        if (isset($_GET['msg'])) {
            $pagina = str_replace('{msg}', '<div>'.$_GET['msg'].'</div>',$pagina);
        }else {
            $pagina = str_replace('{msg}', '', $pagina);
        }
        print($pagina);
    }elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['nome'] and $_POST['email'] and $_POST['senha'] and $_POST['confSenha']) {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = strtolower($_POST['senha']);
            $confSenha = strtolower($_POST['confSenha']);
            $count=0;
            
            $sql = 'SELECT * FROM usuarios WHERE email = :email';
            $stmt = preparaComando($sql);
            $bind = array(
                ':email' => $email
            );
            $stmt = bindExecute($stmt, $bind);
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $count++;
              }

            if ($count==0) {
                $verifEmail=true;
            }else {
                $verifEmail=false;
            }
            if ($senha === $confSenha) {
                $verifSenha=true;
            }else {
                $verifSenha=false;
            }
            if ($verifEmail==true and $verifSenha==true) {
                $sql = 'INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)';
                $stmt = preparaComando($sql);

                // -----CRIPTOGRAFIA DA SENHA------------------
                $senha_cript=hash('sha512',$senha);
                // --------------------------------------------
                
                $bind = array(
                    ':nome' => $nome,
                    ':email' => $email,
                    ':senha' => $senha_cript
                );
                $stmt = bindExecute($stmt, $bind);
                
                $msg = "Cadastro realizado!<br>".$nome." ".$email." ".$senha." ".$confSenha;
                header('location:home.php?msg='.$msg);
            }elseif ($verifEmail==true and $verifSenha==false) {
                $msg = "As senhas não coincidem!";
                header('location:cadastro.php?msg='.$msg);
            }elseif ($verifEmail==false and $verifSenha==true) {
                $msg = "Este email já está cadastrado!";
                header('location:cadastro.php?msg='.$msg);
            }else {
                $msg = "Este email já está cadastrado e as senhas não coincidem!";
                header('location:cadastro.php?msg='.$msg);
            }
        }else {
            $msg = "Preencha todos os campos!";
            header('location:cadastro.php?msg='.$msg);
        }
    }


?>