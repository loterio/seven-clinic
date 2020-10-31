<?php

require_once('../assets/funcoes.php');
iniciaSession();

if (isset($_SESSION['status']) and $_SESSION['status'] == 'LOGADO') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $pagina = file_get_contents('agendamento.html');
        if (isset($_SESSION['id'])) {
            $agenda = apresentaAgenda();
            $pagina = str_replace('{msg}', $agenda, $pagina);
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
        }
    }else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['acao'])) {
            if (isset($_SESSION['id'])) {
                if ($_POST['acao'] == 'addMedico') {
                    $nome = isset($_POST['nome']) ? mb_strtoupper($_POST['nome'],'UTF-8') : '';
                    $crm = isset($_POST['crm']) ? mb_strtoupper($_POST['crm'],'UTF-8') : '';
                    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
                    $especializacao = isset($_POST['especializacao']) ? mb_strtoupper($_POST['especializacao'],'UTF-8') : '';
                    $countMedicosIdInicio=0;
                    $countMedicosIdFim=0;
                    $countMedicosCrm=0;

                    $sql1 = 'SELECT COUNT(*) AS idInicio FROM medicos WHERE id_user = :id_user;';
                    $stmt1 = preparaComando($sql1);
                    $bind1 = array(
                        ':id_user' => $_SESSION['id']
                    );
                    $stmt1 = bindExecute($stmt1, $bind1);
                    while ($linha1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                        $countMedicosIdInicio = $linha1['idInicio'];
                    }
                    
                    $sql2 = 'SELECT COUNT(*) AS medicosCrm FROM medicos WHERE id_user = :id_user AND CRM = :CRM;';
                    $stmt2 = preparaComando($sql2);
                    $bind2 = array(
                        ':id_user' => $_SESSION['id'],
                        ':CRM' => $crm
                    );
                    $stmt2 = bindExecute($stmt2, $bind2);
                    while ($linha2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        $countMedicosCrm = $linha2['medicosCrm'];
                    }
                    if ($countMedicosCrm == 0) {  
                        $sql3 = 'INSERT INTO medicos(id_user, nome, CRM, telefone, especializacao) values(:id_user, :nome, :CRM, :telefone, :especializacao);';
                        $stmt3 = preparaComando($sql3);
                        $bind3 = array(
                            ':id_user' => $_SESSION['id'],
                            ':nome' => $nome,
                            ':CRM' => $crm,
                            ':telefone' => $telefone,
                            ':especializacao' => $especializacao
                        );
                        $stmt3 = bindExecute($stmt3, $bind3);
                        
                        $sql4 = 'SELECT COUNT(*) AS idFim FROM  medicos WHERE id_user = :id_user;';
                        $stmt4 = preparaComando($sql4);
                        $bind4 = array(
                            ':id_user' => $_SESSION['id']
                        );
                        $stmt4 = bindExecute($stmt4, $bind4);
                        while ($linha4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                            $countMedicosIdFim = $linha4['idFim'];
                        }
                        // echo($countMedicosIdInicio);
                        // echo($countMedicosIdFim);
                        // echo($countMedicosCrm);
                        if ($countMedicosIdInicio < $countMedicosIdFim) {
                            $_SESSION['msg'] = "Médico cadastrado com sucesso!";
                            header('location:agendamento.php?status=OK'); // Sucesso
                        }
                    }else {
                        $_SESSION['msg'] = "Este CRM já está cadastrado!";
                        header('location:agendamento.php?status=ERRO'); // CRM ja existe
                    }
                }if ($_POST['acao'] == 'addPaciente') {
                    $nome = isset($_POST['nome']) ? mb_strtoupper($_POST['nome'],'UTF-8') : '';
                    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
                    $altura = isset($_POST['altura']) ? $_POST['altura'] : '';
                    $peso = isset($_POST['peso']) ? $_POST['peso'] : '';
                    $nascimento = isset($_POST['nascimento']) ? $_POST['nascimento'] : '';
                    $email = isset($_POST['email']) ? mb_strtolower($_POST['email'],'UTF-8') : '';
                    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
                    $endereco = isset($_POST['endereco']) ? ucwords(mb_strtolower($_POST['endereco'],'UTF-8')) : '';
                    $cidade = isset($_POST['cidade']) ? mb_strtoupper($_POST['cidade'],'UTF-8') : '';
                    $observacoes = isset($_POST['observacoes']) ? $_POST['observacoes'] : '';
                    $countPacientesIdInicio=0;
                    $countPacientesIdFim=0;
                    $countPacientesCpf=0;

                    $sql1 = 'SELECT COUNT(*) AS idInicio FROM pacientes WHERE id_user = :id_user;';
                    $stmt1 = preparaComando($sql1);
                    $bind1 = array(
                        ':id_user' => $_SESSION['id']
                    );
                    $stmt1 = bindExecute($stmt1, $bind1);
                    while ($linha1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                        $countPacientesIdInicio = $linha1['idInicio'];
                    }
                    
                    $sql2 = 'SELECT COUNT(*) AS pacientesCpf FROM pacientes WHERE id_user = :id_user AND CPF = :CPF;';
                    $stmt2 = preparaComando($sql2);
                    $bind2 = array(
                        ':id_user' => $_SESSION['id'],
                        ':CPF' => $cpf
                    );
                    $stmt2 = bindExecute($stmt2, $bind2);
                    while ($linha2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        $countPacientesCpf = $linha2['pacientesCpf'];
                    }
                    if ($countPacientesCpf == 0) {  
                        $sql3 = 'INSERT INTO pacientes(id_user, nome, CPF, altura, peso, data_nascimento, email, telefone, endereco, cidade, observacoes) values(:id_user, :nome, :CPF, :altura, :peso, :data_nascimento, :email, :telefone, :endereco, :cidade, :observacoes);';
                        $stmt3 = preparaComando($sql3);
                        $bind3 = array(
                            ':id_user' => $_SESSION['id'],
                            ':nome' => $nome,
                            ':CPF' => $cpf,
                            ':altura' => $altura,
                            ':peso' => $peso,
                            ':data_nascimento' => $nascimento,
                            ':email' => $email,
                            ':telefone' => $telefone,
                            ':endereco' => $endereco,
                            ':cidade' => $cidade,
                            ':observacoes' => $observacoes
                        );
                        $stmt3 = bindExecute($stmt3, $bind3);
                        
                        $sql4 = 'SELECT COUNT(*) AS idFim FROM  pacientes WHERE id_user = :id_user;';
                        $stmt4 = preparaComando($sql4);
                        $bind4 = array(
                            ':id_user' => $_SESSION['id']
                        );
                        $stmt4 = bindExecute($stmt4, $bind4);
                        while ($linha4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                            $countPacientesIdFim = $linha4['idFim'];
                        }
                        // echo($countPacientesIdInicio);
                        // echo($countPacientesIdFim);
                        // echo($countPacientesCrm);
                        if ($countPacientesIdInicio < $countPacientesIdFim) {
                            $_SESSION['msg'] = "Paciente cadastrado com sucesso!";
                            header('location:agendamento.php?status=OK'); // Sucesso
                        }
                    }else {
                        $_SESSION['msg'] = "Este CPF já está cadastrado!";
                        header('location:agendamento.php?status=ERRO'); // CPF ja existe
                    }



                    
                    // $sql = 'INSERT INTO pacientes(id_user, nome, CPF, altura, peso, data_nascimento, email, telefone, endereco, cidade, observacoes) values(:id_user, :nome, :CPF, :altura, :peso, :data_nascimento, :email, :telefone, :endereco, :cidade, :observacoes);';
                    // $stmt = preparaComando($sql);
                    // $bind = array(
                    //     ':id_user' => $_SESSION['id'],
                    //     ':nome' => $nome,
                    //     ':CPF' => $cpf,
                    //     ':altura' => $altura,
                    //     ':peso' => $peso,
                    //     ':data_nascimento' => $nascimento,
                    //     ':email' => $email,
                    //     ':telefone' => $telefone,
                    //     ':endereco' => $endereco,
                    //     ':cidade' => $cidade,
                    //     ':observacoes' => $observacoes
                    // );
                    // // var_dump($bind);
                    // $stmt = bindExecute($stmt, $bind);
                    // header('location:agendamento.php');
                }else {
                    echo("Função indísponível!");
                }
            }else {
                header('location:agendamento.php');
            }
        }else {
            header('location:agendamento.php');
        }
    }else {
        header('location:sair.php');
    }
}else {
    header('location:sair.php');
}

?>