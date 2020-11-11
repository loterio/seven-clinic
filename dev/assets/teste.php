<?php

require_once('funcoes.php');
iniciaSession();
require_once('medico.class.php');
require_once('paciente.class.php');
require_once('consulta.class.php');
$medico = new Medico(1, 16, 'Felipe CLASSE 2', '34353434', 'Geral');
$medico->setAddMedico();

$paciente = new Paciente(1, 'Uelinton teske', '87744', 1, 60, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'nenhuma');
$paciente->setAddPaciente();

$consulta = new Consulta(1, '2020-11-12', '07:30:00', '07:45:00', 120, 'ok', 13, 2, 0);
$consulta->setAddConsulta();

?>