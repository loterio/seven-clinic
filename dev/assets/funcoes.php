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

function apresentaAgenda(){
    $dados = "";
    $id = $_SESSION['id'];
    $sqlDatas = 'SELECT DISTINCT data_consulta FROM consultas WHERE id_user = :id_user ORDER BY data_consulta';
    $stmtDatas = preparaComando($sqlDatas);
    $bindDatas = array(
        ':id_user' => $id
    );
    $stmtDatas = bindExecute($stmtDatas, $bindDatas);
    while ($linhaDatas = $stmtDatas->fetch(PDO::FETCH_ASSOC)) {
        // ------- ABRE CARD "DATA" --------
        $dados .= '
        <div class="eventos-data">
            <div class="card-data">
                <span class="data">';
                $dados .= formataData($linhaDatas['data_consulta']);
                $dados .= '</span>
                <img src="../assets/img/setaBaixo.svg" alt="">
            </div>
        ';
        // echo($linhaDatas['data_consulta']."<br>");
        $sqlConsultas = 'SELECT C.*, P.nome AS paciente, M.nome AS medico FROM consultas C INNER JOIN pacientes P ON C.id_paciente = P.id_paciente INNER JOIN medicos M ON C.id_medico = M.id_medico WHERE C.id_user = :id_user AND data_consulta = :data_consulta ORDER BY hora_inicio';
        $stmtConsultas = preparaComando($sqlConsultas);
        $bindConsultas = array(
            ':id_user' => $id,
            ':data_consulta' => $linhaDatas['data_consulta']
        );
        $stmtConsultas = bindExecute($stmtConsultas, $bindConsultas);
        while ($linhaConsultas = $stmtConsultas->fetch(PDO::FETCH_ASSOC)) {
            // echo($linhaConsultas['id_paciente']."<br>");
            // ------- ABRE CARD "CONSULTA" --------
            $dados .= '
            <div class="evento">
                <div class="dados-paciente">
                    <div class="imagem" style="background-image: url(../assets/img/pacientes/);"></div>
                    <div class="medico-paciente">
                        <span class="paciente">';
                        $dados .= $linhaConsultas['paciente'];
                        $dados .= '</span>
                        <span class="medico">';
                        $dados .= $linhaConsultas['medico'];
                        $dados .= '</span>
                    </div>
                </div>
            <span class="horario">';
            $dados .= formataHora($linhaConsultas['hora_inicio']);
            $dados .= ' - ';
            $dados .= formataHora($linhaConsultas['hora_fim']);
            $dados .= '</span>
            </div>';
            // ------- FECHA CARD "CONSULTA" --------
        }
        // ------- FECHA CARD "DATA" --------
        $dados .= '</div>';
    }
    return $dados;
}

function formataData($dataInicio){
    $vetData = explode('-', $dataInicio);
    switch ($vetData[1]) {
        case 1:
            $mes = 'Janeiro';
            break;
        case 2:
            $mes = 'Fevereiro';
            break;
        case 3:
            $mes = 'Março';
            break;
        case 4:
            $mes = 'Abril';
            break;
        case 5:
            $mes = 'Maio';
            break;
        case 6:
            $mes = 'Junho';
            break;
        case 7:
            $mes = 'Julho';
            break;
        case 8:
            $mes = 'Agosto';
            break;
        case 9:
            $mes = 'Setembro';
            break;
        case 10:
            $mes = 'Outubro';
            break;
        case 11:
            $mes = 'Novembro';
            break;
        case 12:
            $mes = 'Dezembro';
            break; 
    }
    $data = $vetData[2]." de ".$mes." de ".$vetData[0];
    return $data;

}
function formataHora($horaInicio){
    $vetHora = explode(':', $horaInicio);
    $hora = $vetHora[0].":".$vetHora[1];
    return $hora;
}

?>