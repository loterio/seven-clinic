<?php

require_once('funcoes.php');
iniciaSession();
require_once('medico.class.php');
require_once('paciente.class.php');
require_once('consulta.class.php');
require_once('usuario.class.php');



// EXEMPLO -->> $medico = new Medico(id_user, CRM, 'nome', 'telefone', 'especializacao');
$medico = new Medico(1, 112, 'Felipe CLASSE 12', '44444444', 'nada');


// EXEMPLO -->> echo $medico->setAddMedico();
// echo $medico->setAddMedico();

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
$paciente = new Paciente(1, 'Uelinton teske', '87744', 1, 110, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');


// EXEMPLO -->> echo $paciente->setAddPaciente();
// echo $paciente->setAddPaciente();

// ---------RETORNOS---------
// Paciente cadastrado com sucesso!
// Erro ao adicionar paciente!
// Este CPF já está cadastrado!


// EXEMPLO  -->> echo $paciente->setAlteraPaciente(id_user);
// echo $paciente->setAlteraPaciente(11);

// ---------RETORNOS---------
// Paciente atualizado com sucesso!
// Não foi possível atualizar o paciente!
// Este CPF já está cadastrado!


// EXEMPLO -->> $consulta = new Consulta(id_user, 'data_consulta', 'hora_inicio', 'hora_fim', valor, 'observaçoes', id_paciente, id_medico, estado);
$consulta = new Consulta(1, '2020-11-12', '06:00:00', '08:30:00', 120, 'ok', 2, 2, 0);


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


// EXEMPLO -->> $usuario = new Usuario('email');
$usuario = new Usuario('jao123@gmail.com');


// EXEMPLO -->> echo $usuario->setAlteraUsuario(id_user, 'nome', 'senha', 'confSenha')
// echo $usuario->setAlteraUsuario(1, 'jao', 'jao1234', 'jao1234')

// ---------RETORNOS---------
// Usuário atualizado com sucesso!
// Não foi possível atualizar o usuário!
// Este e-mail já está cadastrado!
// A senha e a confirmação de senha não coincidem!

?>