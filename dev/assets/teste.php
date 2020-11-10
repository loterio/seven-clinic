<?php

require_once('funcoes.php');
iniciaSession();
require_once('medico.class.php');
$medico = new Medico(1, 5, 'Felipe CLASSE 2', '34353434', 'Geral');
// var_dump($medico);
$medico->setAddMedico();

?>