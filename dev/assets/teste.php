<?php

require_once('funcoes.php');
iniciaSession();


// EXEMPLO -->> $usuario = new Usuario('email');
$usuario = new Usuario('jao123@gmail.com');
$usuario->setId(1);

// $pessoa = new Pessoa($usuario, 'Felipe', '47996994858');
// var_dump($pessoa->apresentar());

// echo $pessoa->getContato('telefone');

// EXEMPLO -->> echo $usuario->setAlteraUsuario(id_user, 'nome', 'senha', 'confSenha')
// echo $usuario->setAlteraUsuario(1, 'jao', 'jao1234', 'jao1234')

// ---------RETORNOS---------
// Usuário atualizado com sucesso!
// Não foi possível atualizar o usuário!
// Este e-mail já está cadastrado!
// A senha e a confirmação de senha não coincidem!

// EXEMPLO -->> $medico = new Medico(id_user, CRM, 'nome', 'telefone', 'especializacao');
$medico = new Medico($usuario, 112, 'aaa', '323', 'nada');
// echo $medico->getContato('telefone');
// $medico->setId(2);
// var_dump($medico);
// echo $medico->getId();

// echo $medico->getUser()->getId();

// EXEMPLO -->> echo $medico->setAddMedico();
echo $medico->setAddMedico();

// ---------RETORNOS---------
// Médico cadastrado com sucesso!
// Erro ao adicionar médico!
// Este CRM já está cadastrado!


// EXEMPLO -->> echo $medico->setAlteraMedico(id_medico);
// echo $medico->setAlteraMedico(12);

// ---------RETORNOS---------
// Médico atualizado com sucesso!
// Não foi possível atualizar o médico!
// Este CRM já está cadastrado!



// EXEMPLO -->> $paciente = new Paciente(id_user, 'nome', 'CPF', altura, peso, 'data_nascimento', 'email', 'telefone', 'endereço', 'cidade', 'observacoes');
$paciente = new Paciente($usuario, 'beltrano', '0087744', 1, 110, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');
// var_dump($paciente);
// echo $paciente->getUser()->getId();
// echo $paciente->getContato('telefone');
// var_dump($paciente->apresentar());

// EXEMPLO -->> echo $paciente->setAddPaciente();
// echo $paciente->setAddPaciente();

// ---------RETORNOS---------
// Paciente cadastrado com sucesso!
// Erro ao adicionar paciente!
// Este CPF já está cadastrado!


// EXEMPLO  -->> echo $paciente->setAlteraPaciente(id_paciente);
// echo $paciente->setAlteraPaciente(11);

// ---------RETORNOS---------
// Paciente atualizado com sucesso!
// Não foi possível atualizar o paciente!
// Este CPF já está cadastrado!
 

// EXEMPLO -->> $consulta = new Consulta(id_user, 'data_consulta', 'hora_inicio', 'hora_fim', valor, 'observaçoes', estado);
// $consulta = new Consulta($usuario, '2020-11-12', '06:00:00', '08:30:00', 120, 'ok', 0);
// $consulta->setAddMedico($medico);
// $consulta->setAddPaciente($paciente);


// echo $consulta->getUser()->getId();

// EXEMPLO -->> echo $consulta->setAddConsulta();
// echo $consulta->setAddConsulta();

// ---------RETORNOS---------
// Consulta cadastrada com sucesso!
// Erro ao adicionar consulta!
// Este horário já possui outra consulta agendada para este paciente!
// Este horário já possui outra consulta agendada para este médico!


// EXEMPLO -->> echo $consulta->setAlteraConsulta(id_consulta);
// echo $consulta->setAlteraConsulta(1);

// ---------RETORNOS---------
// Consulta atualizada com sucesso!
// Não foi possível atualizar a consulta!
// Este horário já possui outra consulta agendada para este paciente!
// Este horário já possui outra consulta agendada para este médico!




//------------ PROCESSO PARA ADICIONAR UMA CONSULTA ----------

// $usuarioCons = new Usuario('jao123@gmail.com');
// $usuarioCons->setId(1);
// $medicoCons = new Medico($usuarioCons, 1112, 'Felipe TESTE CONSULTA', '44444444', 'nada');
// echo $medicoCons->setAddMedico();
// $pacienteCons = new Paciente($usuarioCons, 'Uelinton teske', '8774477', 1, 110, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');
// echo $pacienteCons->setAddPaciente();
// $consultaCons = new Consulta($usuarioCons, '2020-12-01', '06:00:00', '08:30:00', 120, 'ok', 0);
// $consultaCons->setAddMedico($medicoCons);
// $consultaCons->setAddPaciente($pacienteCons);
// echo $consultaCons->setAddConsulta();


// ---------------------------------------------------------------

// $relatorioMedico = new RelatorioMedico($usuario, '2020-10-14', '2020-11-13', 1);
// echo "valorTotal: ".$relatorioMedico->geraRelatorio();

// $relatorioPaciente = new RelatorioPaciente($usuario, '2020-10-14', '2020-11-13', 1);
// echo "valorTotal: ".$relatorioPaciente->geraRelatorio();

?>