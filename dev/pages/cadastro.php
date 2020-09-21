<?php
    require_once('../assets/funcoes.php');
    iniciaSession();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('cadastro.html');
        if (isset($_GET['status']) and $_GET['status'] == 'ERRO') {
            // Recebe o 'msg', pega os valores do session e substitui
            if (isset($_SESSION['nome'])) {
                $pagina = str_replace('{nome}', $_SESSION['nome'], $pagina);
            }else {
                $pagina = str_replace('{nome}', '', $pagina);
            }
            if (isset($_SESSION['email'])) {
                $pagina = str_replace('{email}', $_SESSION['email'], $pagina);
            }else {
                $pagina = str_replace('{email}', '', $pagina);
            }
            if (isset($_SESSION['msg'])) {
                $pagina = str_replace('{msg}', '<div>'.$_SESSION['msg'].'</div>', $pagina);
            }else {
                $pagina = str_replace('{msg}', '', $pagina);
            }
        }else {
            // Não recebe 'msg', limpa o {msg} e os valores dos inputs

            $pagina = str_replace('{msg}', '', $pagina);
            $pagina = str_replace('{nome}', '', $pagina);
            $pagina = str_replace('{email}', '', $pagina);
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
                
                $sql = 'SELECT COUNT(*) as qtd FROM usuarios WHERE email = :email';
                $comando = preparaComando($sql);
                $bind = array(
                    ':email' => $email
                );
                $comando = bindExecute($comando, $bind);
                $linha = $comando->fetch(PDO::FETCH_ASSOC);
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
                    $_SESSION['msg'] = 'Cadastro realizado com sucesso!';
                    $_SESSION['id'] = $linha['id'];
                    $_SESSION['nome'] = $linha['nome'];
                    $_SESSION['email'] = $linha['email'];
                    header('location:home.php?status=OK&nome='.$_SESSION['nome']);
                }else {
                    $_SESSION['msg'] = "Erro ao cadastrar. Tente novamente!";
                    $_SESSION['nome'] = $nome;
                    $_SESSION['email'] = $email;
                    header('location:cadastro.php?status=ERRO');
                }
            }elseif ($verifEmail==true and $verifSenha==false) {
                $_SESSION['msg'] = "As senhas não coincidem!";
                $_SESSION['nome'] = $nome;
                $_SESSION['email'] = $email;
                header('location:cadastro.php?status=ERRO');
            }elseif ($verifEmail==false and $verifSenha==true) {
                $_SESSION['msg'] = "Este email já está cadastrado!";
                $_SESSION['nome'] = $nome;
                $_SESSION['email'] = $email;
                header('location:cadastro.php?status=ERRO');
            }else {
                $_SESSION['msg'] = "Este email já está cadastrado e as senhas não coincidem!";
                $_SESSION['nome'] = $nome;
                $_SESSION['email'] = $email;
                header('location:cadastro.php?status=ERRO');
            }
        }else {
            // FALTA VERIFICAÇÃO SE UM DELES JA FOI INSERIDO
            $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $_SESSION['msg'] = "Preencha todos os campos!";
            $_SESSION['nome'] = $nome;
            $_SESSION['email'] = $email;
            header('location:cadastro.php?status=ERRO');
        }
    }


?>