<?php
require_once('medico.class.php');
require_once('paciente.class.php');
require_once('consulta.class.php');
require_once('usuario.class.php');
require_once('contato.class.php');
require_once('pessoa.class.php');
require_once('relatorio.class.php');
require_once('relatorioMedico.class.php');
require_once('relatorioPaciente.class.php');

require_once('conf/default.inc.php');
function criarConexao(){
    require_once('conf/conf.inc.php');
    try {
        $conexao = new PDO(MYSQL,USER,PASSWORD, array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
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

function apresentaAgenda($busca, $data, $filtro, $pesquisa){
    $dados = "";
    $id = $_SESSION['id'];
    // $id = 1;
    $dataHoje = date('Y-m-d');
    $count = 0;
    // ------ INICIO BUSCA --------
    if (((($busca != '' OR $data != '') AND $filtro != '') OR $filtro == 'T')AND $pesquisa != '') {
        switch ($filtro) {
            // case 'T':
            //     $sqlDatas = "SELECT DISTINCT C.data_consulta FROM consultas C INNER JOIN pacientes P ON C.id_paciente = P.id_paciente INNER JOIN medicos M ON C.id_medico = M.id_medico WHERE C.id_user = :id_user AND C.data_consulta >= :data_hoje AND (M.nome LIKE :busca OR P.nome LIKE :busca) ORDER BY C.data_consulta";
            //     // (M.nome LIKE '%:busca%' OR P.nome LIKE '%:busca%')
            //     $stmtDatas = preparaComando($sqlDatas);
            //     $bindDatas = array(
            //         ':id_user' => $id,
            //         ':data_hoje' => $dataHoje,
            //         ':busca' => '%'.$busca.'%'
            //     );
            // break;
            case 'P':
                // $buscar = '%'.$busca.'%';
                $sqlDatas = "SELECT DISTINCT C.data_consulta FROM consultas C INNER JOIN pacientes P ON C.id_paciente = P.id_paciente WHERE C.id_user = :id_user AND C.data_consulta >= :data_hoje AND P.nome LIKE :busca ORDER BY C.data_consulta";
                $stmtDatas = preparaComando($sqlDatas);
                $bindDatas = array(
                    ':id_user' => $id,
                    ':data_hoje' => $dataHoje,
                    ':busca' => '%'.$busca.'%'
                );
                var_dump($sqlDatas);
                var_dump($bindDatas);
            break;
            case 'M':
                $sqlDatas = 'SELECT DISTINCT C.data_consulta FROM consultas C INNER JOIN medicos M ON C.id_medico = M.id_medico WHERE C.id_user = :id_user AND C.data_consulta >= :data_hoje AND M.nome LIKE :busca ORDER BY C.data_consulta';
                $stmtDatas = preparaComando($sqlDatas);
                $bindDatas = array(
                    ':id_user' => $id,
                    ':data_hoje' => $dataHoje,
                    ':busca' => '%'.$busca.'%'
                );
            break;
            case 'D':
                $sqlDatas = 'SELECT DISTINCT data_consulta FROM consultas WHERE id_user = :id_user AND data_consulta = :data_busca ORDER BY data_consulta';
                $stmtDatas = preparaComando($sqlDatas);
                $bindDatas = array(
                    ':id_user' => $id,
                    // ':data_hoje' => $dataHoje,
                    ':data_busca' => $data
                );
            break;  
            default:
                $sqlDatas = 'SELECT DISTINCT data_consulta FROM consultas WHERE id_user = :id_user ORDER BY data_consulta';
                $stmtDatas = preparaComando($sqlDatas);
                $bindDatas = array(
                    ':id_user' => $id
                );
            break;
        }
    }else {
        $sqlDatas = 'SELECT DISTINCT data_consulta FROM consultas WHERE id_user = :id_user AND (data_consulta >= :data_hoje OR estado != 1) ORDER BY data_consulta';
        $stmtDatas = preparaComando($sqlDatas);
        $bindDatas = array(
            ':id_user' => $id,
            ':data_hoje' => $dataHoje
        );
    }
    // ------- FIM BUSCA ----------
    
    $stmtDatas = bindExecute($stmtDatas, $bindDatas);
    while ($linhaDatas = $stmtDatas->fetch(PDO::FETCH_ASSOC)) {
        $count++;
        // ------- ABRE CARD "DATA" --------
        $dados .= '
        <div class="eventos-data">
            <div class="card-data">
                <span class="data">';

                $dataCard = explode("-", $linhaDatas['data_consulta']);
                $vetDataHoje = explode("-", $dataHoje);
                
                if ($dataCard[0] == $vetDataHoje[0]) {
                    if ($dataCard[1] == $vetDataHoje[1]) {
                        if ($dataCard[2] == $vetDataHoje[2]) {
                            $dados .= "Hoje";
                        }elseif ($dataCard[2] == ($vetDataHoje[2]+1)) {
                            $dados .= "Amanhã";
                        }else {
                            $dados .= formataData($linhaDatas['data_consulta']);
                        }
                    }else {
                        $dados .= formataData($linhaDatas['data_consulta']);
                    }
                }else {
                    $dados .= formataData($linhaDatas['data_consulta']);
                }
                $dados .= '</span>
                <img src="../assets/img/setaBaixo.svg" alt="">
            </div>
        ';
        // echo($linhaDatas['data_consulta']."<br>");

        if ($busca != '' AND $filtro != '' AND $pesquisa != '') {
            switch ($filtro) {
                // case 'T':
                //     $sqlConsultas = "SELECT C.*, P.nome AS paciente, M.nome AS medico FROM consultas C INNER JOIN pacientes P ON C.id_paciente = P.id_paciente INNER JOIN medicos M ON C.id_medico = M.id_medico WHERE C.id_user = :id_user AND C.data_consulta = :data_consulta AND (M.nome LIKE :busca OR P.nome LIKE :busca) ORDER BY hora_inicio";
                //     $stmtConsultas = preparaComando($sqlConsultas);
                //     $bindConsultas = array(
                //         ':id_user' => $id,
                //         ':data_consulta' => $linhaDatas['data_consulta'],
                //         ':busca' => '%'.$busca.'%'
                //     );
                // break;
                case 'P':
                    $sqlConsultas = "SELECT C.*, P.nome AS paciente, M.nome AS medico FROM consultas C INNER JOIN pacientes P ON C.id_paciente = P.id_paciente INNER JOIN medicos M ON C.id_medico = M.id_medico WHERE C.id_user = :id_user AND C.data_consulta = :data_consulta AND P.nome LIKE :busca ORDER BY C.hora_inicio";
                    $stmtConsultas = preparaComando($sqlConsultas);
                    $bindConsultas = array(
                        ':id_user' => $id,
                        ':data_consulta' => $linhaDatas['data_consulta'],
                        ':busca' => '%'.$busca.'%'
                    );
                break;
                case 'M':
                    $sqlConsultas = "SELECT C.*, P.nome AS paciente, M.nome AS medico FROM consultas C INNER JOIN pacientes P ON C.id_paciente = P.id_paciente INNER JOIN medicos M ON C.id_medico = M.id_medico WHERE C.id_user = :id_user AND C.data_consulta = :data_consulta AND M.nome LIKE :busca ORDER BY C.hora_inicio";
                    $stmtConsultas = preparaComando($sqlConsultas);
                    $bindConsultas = array(
                        ':id_user' => $id,
                        ':data_consulta' => $linhaDatas['data_consulta'],
                        ':busca' => '%'.$busca.'%'
                    );
                break;
                case 'D':
                    $sqlConsultas = 'SELECT C.*, P.nome AS paciente, M.nome AS medico FROM consultas C INNER JOIN pacientes P ON C.id_paciente = P.id_paciente INNER JOIN medicos M ON C.id_medico = M.id_medico WHERE C.id_user = :id_user AND C.data_consulta = :data_consulta ORDER BY C.hora_inicio';
                    $stmtConsultas = preparaComando($sqlConsultas);
                    $bindConsultas = array(
                        ':id_user' => $id,
                        ':data_consulta' => $linhaDatas['data_consulta']
                    );
                break;  
                default:
                    $sqlConsultas = 'SELECT C.*, P.nome AS paciente, M.nome AS medico FROM consultas C INNER JOIN pacientes P ON C.id_paciente = P.id_paciente INNER JOIN medicos M ON C.id_medico = M.id_medico WHERE C.id_user = :id_user AND data_consulta = :data_consulta ORDER BY hora_inicio';
                    $stmtConsultas = preparaComando($sqlConsultas);
                    $bindConsultas = array(
                        ':id_user' => $id,
                        ':data_consulta' => $linhaDatas['data_consulta']
                    );
                break;
            }
        }else {
            $sqlConsultas = 'SELECT C.*, P.nome AS paciente, M.nome AS medico FROM consultas C INNER JOIN pacientes P ON C.id_paciente = P.id_paciente INNER JOIN medicos M ON C.id_medico = M.id_medico WHERE C.id_user = :id_user AND data_consulta = :data_consulta ORDER BY hora_inicio';
            $stmtConsultas = preparaComando($sqlConsultas);
            $bindConsultas = array(
                ':id_user' => $id,
                ':data_consulta' => $linhaDatas['data_consulta']
            );
        }


        $stmtConsultas = bindExecute($stmtConsultas, $bindConsultas);
        while ($linhaConsultas = $stmtConsultas->fetch(PDO::FETCH_ASSOC)) {
            // echo($linhaConsultas['id_paciente']."<br>");
            // ------- ABRE CARD "CONSULTA" --------
            $dados .= '<div class="evento" onclick="ajaxDiv(';
            $dados .= "'detalheConsulta.php?id=";
            $dados .= $linhaConsultas['id_consulta'];
            $dados .= "&acao=detalhe', 'espaco-formulario'); mostraFormulario();";
            $dados .= '"';
            $dados .= '>
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
        // $dados .= date('Y-m-d H:i:s');
    }
    if ($count==0) {
        $dados = "<div style='font-size: 2.4rem;padding-top: 2.4rem;text-align: center;'>Não existem consultas a partir da data de hoje!</div>";
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

function getQnt($tabela, $id_user){
    $count = 0;

    $sql = 'SELECT COUNT(*) AS countId FROM '.$tabela.' WHERE id_user = :id_user;';
    $stmt = preparaComando($sql);
    $bind = array(
        // ':tabela' => strval($tabela),
        ':id_user' => $id_user
    );
    $stmt = bindExecute($stmt, $bind);
    while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $count = $linha['countId'];
    }
    return $count;
}

function buscaPacientes(){
    $dados = '';

    $sql = 'SELECT * FROM pacientes WHERE id_user = :id_user;';
    $stmt = preparaComando($sql);
    $bind = array(
        ':id_user' => $_SESSION['id']
    );
    $stmt = bindExecute($stmt, $bind);
        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dados .= '<option value="';
            $dados .= $linha['id_paciente'];
            $dados .= '">';
            $dados .= $linha['nome'];
            $dados .= ' - ';
            $dados .= $linha['CPF'];
            $dados .= '</option>';
        }
    return $dados;
}

function buscaMedicos(){
    $dados = '';

    $sql = 'SELECT * FROM medicos WHERE id_user = :id_user;';
    $stmt = preparaComando($sql);
    $bind = array(
        ':id_user' => $_SESSION['id']
    );
    $stmt = bindExecute($stmt, $bind);
        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dados .= '<option value="';
            $dados .= $linha['id_medico'];
            $dados .= '">';
            $dados .= $linha['nome'];
            $dados .= ' - ';
            $dados .= $linha['CRM'];
            $dados .= '</option>';
        }
    return $dados;
}

function obtemMedicoPeloId($id){
    $sql = 'SELECT * FROM medicos WHERE id_user = :id_user AND id_medico = :id_medico;';
    $stmt = preparaComando($sql);
    $bind = array(
        ':id_user' => $_SESSION['id'],
        ':id_medico' => $id
    );
    $stmt = bindExecute($stmt, $bind);
        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dados = array(
                'id_user' => $linha['id_user'],
                'id_medico' => $linha['id_medico'],
                'nome' => $linha['nome'],
                'CRM' => $linha['CRM'],
                'telefone' => $linha['telefone'],
                'especializacao' => $linha['especializacao']            
            );
        }
    return $dados;
}

function obtemPacientePeloId($id){
    $sql = 'SELECT * FROM pacientes WHERE id_user = :id_user AND id_paciente = :id_paciente;';
    $stmt = preparaComando($sql);
    $bind = array(
        ':id_user' => $_SESSION['id'],
        ':id_paciente' => $id
    );
    $stmt = bindExecute($stmt, $bind);
        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dados = array(
                'id_user' => $linha['id_user'],
                'id_paciente' => $linha['id_paciente'],
                'nome' => $linha['nome'],
                'CPF' => $linha['CPF'],
                'altura' => $linha['altura'],
                'peso' => $linha['peso'],
                'data_nascimento' => $linha['data_nascimento'],
                'email' => $linha['email'],
                'telefone' => $linha['telefone'],
                'endereco' => $linha['endereco'],
                'cidade' => $linha['cidade'],
                'observacoes' => $linha['observacoes']           
            );
        }
    return $dados;
}

function selectPacientes($paciente){
    $dados = '';

    $sql = 'SELECT * FROM pacientes WHERE id_user = :id_user;';
    $stmt = preparaComando($sql);
    $bind = array(
        ':id_user' => $_SESSION['id']
    );
    $stmt = bindExecute($stmt, $bind);
        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dados .= '<option value="';
            $dados .= $linha['id_paciente'];
            $dados .= '"';
            if ($linha['id_paciente'] == $paciente) {
                $dados .= ' selected';
            }
            $dados .= '>';
            $dados .= $linha['nome'];
            $dados .= ' - ';
            $dados .= $linha['CPF'];
            $dados .= '</option>';
        }
    return $dados;
}

function selectMedicos($medico){
    $dados = '';

    $sql = 'SELECT * FROM medicos WHERE id_user = :id_user;';
    $stmt = preparaComando($sql);
    $bind = array(
        ':id_user' => $_SESSION['id']
    );
    $stmt = bindExecute($stmt, $bind);
        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dados .= '<option value="';
            $dados .= $linha['id_medico'];
            $dados .= '"';
            if ($linha['id_medico'] == $medico) {
                $dados .= ' selected';
            }
            $dados .= '>';
            $dados .= $linha['nome'];
            $dados .= ' - ';
            $dados .= $linha['CRM'];
            $dados .= '</option>';
        }
    return $dados;
}

function apresentaMedico($busca, $filtro){
    $dados = "";
    $id = $_SESSION['id'];
    // $id = 1;
    // $dataHoje = date('Y-m-d');
    $count = 0;
    // ------ INICIO BUSCA --------
    if ($busca != '' AND $filtro == "M") {
        $sqlConsultas = 'SELECT * FROM medicos WHERE id_user = :id_user AND nome LIKE :busca ORDER BY nome';
        $stmtConsultas = preparaComando($sqlConsultas);
        $bindConsultas = array(
            ':id_user' => $id,
            ':busca' => '%'.$busca.'%'
        );
    }else if ($busca != '' AND $filtro == "P") {
        $sqlConsultas = 'SELECT * FROM medicos WHERE id_user = :id_user AND CRM LIKE :busca ORDER BY nome';
        $stmtConsultas = preparaComando($sqlConsultas);
        $bindConsultas = array(
            ':id_user' => $id,
            ':busca' => $busca.'%'
        );
    }else {
        $sqlConsultas = 'SELECT * FROM medicos WHERE id_user = :id_user ORDER BY nome';
        $stmtConsultas = preparaComando($sqlConsultas);
        $bindConsultas = array(
            ':id_user' => $id
        );
    }
    // ------- FIM BUSCA ----------
    
        $stmtConsultas = bindExecute($stmtConsultas, $bindConsultas);
        while ($linhaConsultas = $stmtConsultas->fetch(PDO::FETCH_ASSOC)) {
            $count++;
            // echo($linhaConsultas['id_paciente']."<br>");
            // ------- ABRE CARD "CONSULTA" --------
            $dados .= '<div class="evento" onclick="ajaxDiv(';
            $dados .= "'detalheMedico.php?id=";
            $dados .= $linhaConsultas['id_medico'];
            $dados .= "&acao=detalhe', 'espaco-formulario'); mostraFormulario();";
            $dados .= '"';
            $dados .= '>
                <div class="dados-paciente">
                    <div class="imagem" style="background-image: url(../assets/img/pacientes/);"></div>
                    <div class="medico-paciente">
                        <span class="paciente">';
                        $dados .= $linhaConsultas['nome'];
                        $dados .= '</span>
                        <span class="medico">';
                        $dados .= $linhaConsultas['especializacao'];
                        $dados .= '</span>
                    </div>
                </div>
            <span class="horario">';
            $dados .= $linhaConsultas['CRM'];
            $dados .= '</span>
            </div>';
            // ------- FECHA CARD "CONSULTA" --------
        }

    if ($count==0) {
        $dados = "<div style='font-size: 2.4rem;padding-top: 2.4rem;text-align: center;'>Nenhum médico encontrado!</div>";
    }
    return $dados;
}

function apresentaPaciente($busca, $filtro){
    $dados = "";
    $id = $_SESSION['id'];
    // $id = 1;
    // $dataHoje = date('Y-m-d');
    $count = 0;
    // ------ INICIO BUSCA --------
    if ($busca != '' AND $filtro == "M") {
        $sqlConsultas = 'SELECT * FROM pacientes WHERE id_user = :id_user AND nome LIKE :busca ORDER BY nome';
        $stmtConsultas = preparaComando($sqlConsultas);
        $bindConsultas = array(
            ':id_user' => $id,
            ':busca' => '%'.$busca.'%'
        );
    }else if ($busca != '' AND $filtro == "P") {
        $sqlConsultas = 'SELECT * FROM pacientes WHERE id_user = :id_user AND CPF LIKE :busca ORDER BY nome';
        $stmtConsultas = preparaComando($sqlConsultas);
        $bindConsultas = array(
            ':id_user' => $id,
            ':busca' => $busca.'%'
        );
    }else {
        $sqlConsultas = 'SELECT * FROM pacientes WHERE id_user = :id_user ORDER BY nome';
        $stmtConsultas = preparaComando($sqlConsultas);
        $bindConsultas = array(
            ':id_user' => $id
        );
    }
    // ------- FIM BUSCA ----------
    
        $stmtConsultas = bindExecute($stmtConsultas, $bindConsultas);
        while ($linhaConsultas = $stmtConsultas->fetch(PDO::FETCH_ASSOC)) {
            $count++;
            // echo($linhaConsultas['id_paciente']."<br>");
            // ------- ABRE CARD "CONSULTA" --------
            $dados .= '<div class="evento" onclick="ajaxDiv(';
            $dados .= "'detalhePaciente.php?id=";
            $dados .= $linhaConsultas['id_paciente'];
            $dados .= "&acao=detalhe', 'espaco-formulario'); mostraFormulario();";
            $dados .= '"';
            $dados .= '>
                <div class="dados-paciente">
                    <div class="imagem" style="background-image: url(../assets/img/pacientes/);"></div>
                    <div class="medico-paciente">
                        <span class="paciente">';
                        $dados .= $linhaConsultas['nome'];
                        $dados .= '</span>
                        <span class="medico">';
                        $dados .= $linhaConsultas['cidade'];
                        $dados .= '</span>
                    </div>
                </div>
            <span class="horario">';
            $dados .= $linhaConsultas['CPF'];
            $dados .= '</span>
            </div>';
            // ------- FECHA CARD "CONSULTA" --------
        }

    if ($count==0) {
        $dados = "<div style='font-size: 2.4rem;padding-top: 2.4rem;text-align: center;'>Nenhum paciente encontrado!</div>";
    }
    return $dados;
}

function adicionaMedico($usuario, $link){
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $crm = isset($_POST['crm']) ? $_POST['crm'] : '';
    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
    $especializacao = isset($_POST['especializacao']) ? $_POST['especializacao'] : '';
 
    $medico = new Medico($usuario, $crm, $nome, $telefone, $especializacao);
    $medico->setAddMedico($link);
}

function adicionaPaciente($usuario, $link){
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
    $altura = isset($_POST['altura']) ? $_POST['altura'] : '';
    $peso = isset($_POST['peso']) ? $_POST['peso'] : '';
    $nascimento = isset($_POST['nascimento']) ? $_POST['nascimento'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
    $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : '';
    $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : '';
    $observacoes = isset($_POST['observacoes']) ? $_POST['observacoes'] : '';


    $paciente = new Paciente($usuario, $nome, $cpf, $altura, $peso, $nascimento, $email, $telefone, $endereco, $cidade, $observacoes);
    $paciente->setAddPaciente($link);
}

function adicionaConsulta($usuario, $link){
    $paciente = isset($_POST['paciente']) ? $_POST['paciente'] : '';
    $medico = isset($_POST['medico']) ? $_POST['medico'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $valor = isset($_POST['valor']) ? $_POST['valor'] : '';
    $data = isset($_POST['data']) ? $_POST['data'] : '';
    $hora_inicio = isset($_POST['hora_inicio']) ? $_POST['hora_inicio'] : '';
    $hora_final = isset($_POST['hora_final']) ? $_POST['hora_final'] : '';

    $consulta = new Consulta($usuario, $data, $hora_inicio, $hora_final, $valor, $descricao, 0);
    $dadosMed = obtemMedicoPeloId($medico);
    $medico = new Medico($usuario, $dadosMed['CRM'], $dadosMed['nome'], $dadosMed['telefone'], $dadosMed['especializacao']);
    $medico->setId($medico->getId());
    $consulta->setAddMedico($medico);
    $dadosPac = obtemPacientePeloId($paciente);
    $paciente = new Paciente($usuario, $dadosPac['nome'], $dadosPac['CPF'], $dadosPac['altura'], $dadosPac['peso'], $dadosPac['data_nascimento'], $dadosPac['email'], $dadosPac['telefone'], $dadosPac['endereco'], $dadosPac['cidade'], $dadosPac['observacoes']);
    $paciente->setId($paciente->getId());
    $consulta->setAddPaciente($paciente);
    
    $consulta->setAddConsulta($link);
}
?>