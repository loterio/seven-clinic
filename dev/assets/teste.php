<?php

require_once('funcoes.php');
iniciaSession();
require_once('medico.class.php');
require_once('paciente.class.php');
$medico = new Medico(1, 7, 'Felipe CLASSE 2', '34353434', 'Geral');
$medico->setAddMedico();

$paciente = new Paciente(1, 'Uelinton teske', '99883344', 1, 60, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'nenhuma');
$paciente->setAddPaciente();


?>