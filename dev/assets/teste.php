<?php

require_once('funcoes.php');
iniciaSession();
require_once('medico.class.php');
require_once('paciente.class.php');
require_once('consulta.class.php');
$medico = new Medico(1, 112, 'Felipe CLASSE 12', '44444444', 'nada');
// echo $medico->setAddMedico();
// echo $medico->setAlteraMedico(12);

$paciente = new Paciente(1, 'Uelinton teske', '87744', 1, 110, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');
// echo $paciente->setAddPaciente();
// echo $paciente->setAlteraPaciente(11);


$consulta = new Consulta(1, '2020-11-12', '07:30:00', '07:45:00', 120, 'ok', 13, 2, 0);
// echo $consulta->setAddConsulta();

?>