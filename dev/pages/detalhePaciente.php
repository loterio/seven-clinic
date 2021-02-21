<?php


require_once('../assets/funcoes.php');
iniciaSession();

if (isset($_SESSION['status']) and $_SESSION['status'] == 'LOGADO') {
    $usuario = new Usuario($_SESSION['email']);
    $usuario->setId($_SESSION['id']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('detalhePaciente.html');
        if (isset($_SESSION['id'])) {
            $id_paciente = isset($_GET['id']) ? $_GET['id'] : '';
            $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
            if ($id_paciente != '') {
                
                $sqlPaciente = 'SELECT * FROM pacientes WHERE id_user = :id_user AND id_paciente = :id_paciente';
                $stmtPaciente = preparaComando($sqlPaciente);
                $bindPaciente = array(
                    ':id_user' => $_SESSION['id'],
                    ':id_paciente' => $id_paciente
                );
                $stmtPaciente = bindExecute($stmtPaciente, $bindPaciente);
                $dadosPaciente = $stmtPaciente->fetch(PDO::FETCH_ASSOC);

                // if ($acao == 'alterar') {
                //     $pagina = str_replace('{readonly}', '', $pagina);
                //     $dados = '<button type="button" onclick="fechaFormulario()">Cancelar</button>';
                //     $dados .= '<button type="submit" name="acao" value="alteraPaciente">Salvar</button>';
                //     $pagina = str_replace('{botao}', $dados, $pagina);
                // }else{
                //     $pagina = str_replace('{readonly}', 'readonly', $pagina);
                //     $dados = '<button type="submit" name="acao" value="excluiPaciente">Excluir</button>';
                //     $dados .= '<button type="button" onclick="ajaxDiv(';
                //     $dados .= "'detalhePaciente.php?id=";
                //     $dados .= $dadosConsulta['id_paciente'];
                //     $dados .= "&acao=alterar', 'espaco-formulario'); mostraFormulario();";
                //     $dados .= '"';
                //     $dados .= '>Alterar</button>';
                //     $pagina = str_replace('{botao}', $dados, $pagina);
                // }
                // $dadosConsulta['paciente'];

                $pagina = str_replace('{id_paciente}', $dadosPaciente['id_paciente'], $pagina);
                $pagina = str_replace('{nome}', $dadosPaciente['nome'], $pagina);
                $pagina = str_replace('{cpf}', $dadosPaciente['CPF'], $pagina);
                $pagina = str_replace('{altura}', $dadosPaciente['altura'], $pagina);
                $pagina = str_replace('{peso}', $dadosPaciente['peso'], $pagina);
                $pagina = str_replace('{nascimento}', $dadosPaciente['data_nascimento'], $pagina);
                $pagina = str_replace('{email}', $dadosPaciente['email'], $pagina);
                $pagina = str_replace('{telefone}', $dadosPaciente['telefone'], $pagina);
                $pagina = str_replace('{endereco}', $dadosPaciente['endereco'], $pagina);
                $pagina = str_replace('{cidade}', $dadosPaciente['cidade'], $pagina);
                $pagina = str_replace('{observacoes}', $dadosPaciente['observacoes'], $pagina);
                // echo $dadosConsulta['nome'];
    
                
            }





            // $paciente = isset($_POST['paciente']) ? $_POST['paciente'] : '';
            // $medico = isset($_POST['medico']) ? $_POST['medico'] : '';
            // $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
            // $valor = isset($_POST['valor']) ? $_POST['valor'] : '';
            // $data = isset($_POST['data']) ? $_POST['data'] : '';
            // $hora_inicio = isset($_POST['hora_inicio']) ? $_POST['hora_inicio'] : '';
            // $hora_final = isset($_POST['hora_final']) ? $_POST['hora_final'] : '';

            // $consulta = new Consulta($usuario, $data, $hora_inicio, $hora_final, $valor, $descricao, $paciente, $medico, 0);
            // $dadosMed = obtemMedicoPeloId($medico);
            // $medico = new Medico($usuario, $dadosMed['CRM'], $dadosMed['nome'], $dadosMed['telefone'], $dadosMed['especializacao']);
            // $medico->setId($medico->getId());
            // $consulta->setAddMedico($medico);
            // $dadosPac = obtemPacientePeloId($paciente);
            // $paciente = new Paciente($usuario, $dadosPac['nome'], $dadosPac['CPF'], $dadosPac['altura'], $dadosPac['peso'], $dadosPac['data_nascimento'], $dadosPac['email'], $dadosPac['telefone'], $dadosPac['endereco'], $dadosPac['cidade'], $dadosPac['observacoes']);
            // $paciente->setId($paciente->getId());
            // $consulta->setAddPaciente($paciente);

            // $pagina = str_replace('{op-pacientes}', buscaPacientes(), $pagina);
            // $pagina = str_replace('{op-medicos}', buscaMedicos(), $pagina);
            // // $pagina = str_replace('{data}', $data, $pagina);
            // // $pagina = str_replace('{msg}', $agenda, $pagina);
            
            // if (isset($_GET['status'])){
            //     if ($_GET['status'] == 'ERRO' OR $_GET['status'] == 'OK' AND isset($_SESSION['msg'])) {   
            //         $pagina = str_replace('{erro}', 'alert("'.$_SESSION['msg'].'");', $pagina);
            //     }else {
            //         $pagina = str_replace('{erro}', '', $pagina);
            //     }
            // }else {
            //     $pagina = str_replace('{erro}', '', $pagina);
            // }
            
            
            print($pagina);
            // $pagina = str_replace('{filtro}', $filtro, $pagina);
        }else {
            header('location:sair.php');
        }
    }else {
        echo("Função indísponível!");
    }
}else {
  header('location:sair.php');
}