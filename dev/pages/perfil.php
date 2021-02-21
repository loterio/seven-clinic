<?php


require_once('../assets/funcoes.php');
iniciaSession();

if (isset($_SESSION['status']) and $_SESSION['status'] == 'LOGADO') {
    $usuario = new Usuario($_SESSION['email']);
    $usuario->setId($_SESSION['id']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('perfil.html');
        if (isset($_SESSION['id'])) {
            // $id_user = isset($_GET['id']) ? $_GET['id'] : '';
            $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
            $link = isset($_GET['link']) ? $_GET['link'] : '';
            if ($acao != '') {
                // if ($acao == 'detalhe') {
                    
                    
                    $sqlConsultas = 'SELECT * FROM usuarios WHERE id = :id';
                    $stmtConsultas = preparaComando($sqlConsultas);
                    $bindConsultas = array(
                        ':id' => $_SESSION['id']
                    );
                    $stmtConsultas = bindExecute($stmtConsultas, $bindConsultas);
                    $dadosConsulta = $stmtConsultas->fetch(PDO::FETCH_ASSOC);
                    
                    if ($acao == 'alterar') {
                        $pagina = str_replace('{readonly}', 'required', $pagina);
                        $dados = '<button type="button" onclick="fechaFormulario()">Cancelar</button>';
                        $dados .= '<button type="submit" name="acao" value="alteraUsuario">Salvar</button>';
                        $pagina = str_replace('{botao}', $dados, $pagina);
                        $campos = 
                        '<div class="input input-pequeno">
                            <label for="senha">Senha</label>
                            <input type="password" id="senha" name="senha" value="" minlength="6" placeholder="Vazio não altera senha" {readonly}>
                        </div>
                        <div class="input input-pequeno">
                            <label for="conf_senha">Conf. senha</label>
                            <input type="password" id="conf_senha" name="conf_senha" minlength="6" value="" placeholder="Vazio não altera senha" {readonly}>
                        </div>';
                        // $campos .= '<button type="submit" name="acao" value="alteraUsuario">Salvar</button>';
                        $pagina = str_replace('{campos}', $campos, $pagina);
                        $pagina = str_replace('{readonly}', '', $pagina);
                    }else{
                        $dados = '<button type="button" onclick="fechaFormulario()">Cancelar</button>';
                        $dados .= '<button type="button" onclick="ajaxDiv(';
                        $dados .= "'perfil.php?id=";
                        $dados .= $dadosConsulta['id'];
                        $dados .= "&acao=alterar&link={link}', 'espaco-formulario'); mostraFormulario();";
                        $dados .= '"';
                        $dados .= '>Alterar</button>';
                        $pagina = str_replace('{botao}', $dados, $pagina);
                        $campos = 
                        '<div class="input input-grande">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" minlength="6" value="" {readonly}>
                        </div>';
                        $pagina = str_replace('{campos}', $campos, $pagina);
                        $pagina = str_replace('{readonly}', 'readonly', $pagina);
                    }
                    // $dadosConsulta['paciente'];
                    $pagina = str_replace('{link}', $link, $pagina);
                    $pagina = str_replace('{nome}', $dadosConsulta['nome'], $pagina);
                    $pagina = str_replace('{email}', $dadosConsulta['email'], $pagina);
                // }
                
            }
                
                
                
                print($pagina);
            // $pagina = str_replace('{filtro}', $filtro, $pagina);
        }else {
            header('location:sair.php');
        }
    }else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
        $conf_senha = isset($_POST['conf_senha']) ? $_POST['conf_senha'] : '';
        $acao = isset($_POST['acao']) ? $_POST['acao'] : '';
        $link = isset($_POST['link']) ? $_POST['link'] : '';
        // var_dump($_POST);
        if ($acao == 'alteraUsuario') {
            $usuario->setAlteraUsuario($email, $nome, $senha, $conf_senha, $link);
        }else {
            echo("Função indísponível!");
        }
    }else {
        echo("Função indísponível!");
    }
}else {
  header('location:sair.php');
}