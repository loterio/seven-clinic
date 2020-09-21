<?php
function criarConexao(){
    require_once('conf/conf.inc.php');
    try {
        $conexao = new PDO(MYSQL,USER,PASSWORD);
        return $conexao;
    } catch (PDOExeption $e) {
        print('Erro ao conectar com o banco de dados. Favor verificar parâmetros!');
        die();
    }catch(Exeption $e){
        print('Erro genérico. Entre em contato com o administrador do site!');
        die();
    }
}

function preparaComando($sql){
    try {
        $conexao = criarConexao();
        $comando = $conexao->prepare($sql);
        return $comando;
    } catch (Execption $e) {
        print('Erro ao preparar o comando!');
        die();
    }
}

function bindExecute($comando, &$dados){
    try {
        foreach ($dados as $chave => &$valor) {
            $comando->bindParam($chave, $valor);
        }
        $comando = executaComando($comando);
        return $comando;
    } catch (Execption $e) {
        print('Erro ao realizar bind!');
        die();
    }
}

function executaComando($comando){
    try {
        $comando->execute();
        return $comando;
    } catch (Exeption $e) {
        print('Erro ao executar o comando. '.$e->getMessage());
        die();
    }
}

function iniciaSession(){
    if ( session_status() !== PHP_SESSION_ACTIVE )
    {
        session_start();
    }
}

function limpaSession(){
    // Limpa a sessão 
    session_unset();
    session_destroy();
    // session_write_close();
    // setcookie(session_name(),'',0,'/');
    // session_regenerate_id(true);
}
?>