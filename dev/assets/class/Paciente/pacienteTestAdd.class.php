<?php
namespace Classes\Paciente;
use PHPUnit\Framework\TestCase;
require_once "paciente.class.php";

class PacienteTesteAdd extends TestCase 
{
  public function testSetAddPacienteNovo() {
    $paciente = new Paciente(1, 'Uelinton teske', '87990', 1, 110, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');
    $this->assertContains($paciente->setAddPaciente(), "Paciente cadastrado com sucesso!");
  }

  public function testSetAddPacienteCpfExistente() {
    $paciente = new Paciente(1, 'Uelinton teske', '87744', 1, 110, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');
    $this->assertContains($paciente->setAddPaciente(), "Este CPF já está cadastrado!");
  }

  public function testSetAddPacienteUsuarioInexistente() {
    $idUsuarioInexistente = 999;
    $paciente = new Paciente($idUsuarioInexistente, 'Uelinton teske', '87744', 1, 110, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');
    $this->assertContains($paciente->setAddPaciente(), "Erro ao adicionar paciente!");
  }
}