<?php
use PHPUnit\Framework\TestCase;
require_once "medico.class.php";

class MedicoTesteAdd extends TestCase 
{
    public function testSetAddMedicoNovo() {
      $medico = new Medico(1, 112, 'Felipe CLASSE 12', '44444444', 'nada');
      $this->assertContains($medico->setAddMedico(), "Médico cadastrado com sucesso!");
    }

    public function testSetAddMedicoExistente() {
      $medico = new Medico(1, 112, 'Felipe CLASSE 12', '44444444', 'nada');
      $this->assertContains($medico->setAddMedico(), "Este CRM já está cadastrado!");
    }

    public function testSetAddMedicoUsuarioInvalido() {
      $medico = new Medico(2, 112, 'Felipe CLASSE 12', '44444444', 'nada');
      $this->assertContains($medico->setAddMedico(), "Erro ao adicionar médico!");
    }
}
?>