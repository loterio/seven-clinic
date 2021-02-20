<?php
namespace App\Medico;

use PHPUnit\Framework\TestCase;
require_once "medico.class.php";

class MedicoTesteAlterar extends TestCase 
{
    public function testSetAlteraMedicoExistente() {
      $medico = new Medico(1, 200, 'Fabio CLASSE 12', '44444455', 'nada');
      $medicoAtualizado = new Medico(1, 200, 'Fabio CLASSE 25', '44444455', 'nada');
      $medico->setAddMedico();
      $idMedico = $medico->getIdMedico();
      $this->assertContains($medicoAtualizado->setAlteraMedico($idMedico), "Médico atualizado com sucesso!");
    }

    public function testSetAlteraMedicoComCrmExistente() {
      $crmMedicoUelinton = 823;
      $medicoUelinton = new Medico(1, $crmMedicoUelinton, 'Uelinton CLASSE 12', '44444544', 'nada');
      $medicoHenrique = new Medico(1, 314, 'Henrique CLASSE 12', '44444555', 'nada');
      $medicoHenriqueAtualizado = new Medico(1, $crmMedicoUelinton, 'Henrique CLASSE 12', '44444455', 'nada');
      $medicoUelinton->setAddMedico();
      $medicoHenrique->setAddMedico();
      $idMedicoHenrique = $medicoHenrique->getIdMedico();
      $this->assertContains($medicoHenriqueAtualizado->setAlteraMedico($idMedicoHenrique), "Este CRM já está cadastrado!");
    }

    public function testSetAlteraMedicoUsuarioInexistente() {
      $idUsuarioInexistente = 999999;
      $medico = new Medico($idUsuarioInexistente, 112, 'Camilly 12', '44444444', 'nada');
      $idMedico = $medico->getIdMedico();
      $this->assertContains($medico->setAlteraMedico($idMedico), "Não foi possível atualizar o médico!");
    }

}
?>