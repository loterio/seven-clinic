<?php

require_once('funcoes.php');
iniciaSession();
require_once('medico.class.php');
require_once('paciente.class.php');
require_once('consulta.class.php');
require_once('usuario.class.php');
$medico = new Medico(1, 112, 'Felipe CLASSE 12', '44444444', 'nada');
// echo $medico->setAddMedico();

// ---------RETORNOS---------
// Médico cadastrado com sucesso!
// Erro ao adicionar médico!
// Este CRM já está cadastrado!

// echo $medico->setAlteraMedico(12);

// ---------RETORNOS---------
// Médico atualizado com sucesso!
// Não foi possível atualizar o médico!
// Este CRM já está cadastrado!

$paciente = new Paciente(1, 'Uelinton teske', '87744', 1, 110, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');
// echo $paciente->setAddPaciente();

// ---------RETORNOS---------
// Paciente cadastrado com sucesso!
// Erro ao adicionar paciente!
// Este CPF já está cadastrado!

// echo $paciente->setAlteraPaciente(11);

// ---------RETORNOS---------
// Paciente atualizado com sucesso!
// Não foi possível atualizar o paciente!
// Este CPF já está cadastrado!


$consulta = new Consulta(1, '2020-11-12', '07:30:00', '07:45:00', 120, 'ok', 13, 2, 0);
// echo $consulta->setAddConsulta();

// ---------RETORNOS---------
// Consulta cadastrada com sucesso!
// Erro ao adicionar consulta!
// Este horário já possui outra consulta agendada para este paciente!
// Este horário já possui outra consulta agendada para este médico!


$usuario = new Usuario('jao123@gmail.com');
// echo $usuario->setAlteraUsuario(1, 'jao', 'jao1234', 'jao1234')

// ---------RETORNOS---------
// Usuário atualizado com sucesso!
// Não foi possível atualizar o usuário!
// Este e-mail já está cadastrado!
// A senha e a confirmação de senha não coincidem!

?>