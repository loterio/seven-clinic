<?php

require_once('funcoes.php');
iniciaSession();
require_once('medico.class.php');
$medico = new Medico(1, 1, 'Felipe CLASSE', '34343434', 'Geral');
// var_dump($medico);
$medico->addMedico();

?>