<?php
namespace Classes\Paciente;
use PHPUnit\Framework\TestCase;
require_once "paciente.class.php";

class PacienteTesteAlterar extends TestCase 
{
  public function testSetAlteraPacienteNovo() {
    $paciente = new Paciente(1, 'Uelinton teske', '87744', 1, 110, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');
    $paciente->setAddPaciente();
    $pacienteAtualizado = new Paciente(1, 'Uelinton teske', '87724', 1, 110, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');
    $idPaciente = $paciente->getIdPaciente();
    $this->assertContains($pacienteAtualizado->setAlteraPaciente($idPaciente), "Paciente atualizado com sucesso!");
  }

  public function testSetAlteraPacienteCpfExistente() {
    $cpfPaula = '87344';
    $pacientePaula = new Paciente(1, 'Paula Carvalho', $cpfPaula, 1, 110, '2002-09-26', 'paula.@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');
    $pacienteEduarda = new Paciente(1, 'Eduarda Matini', '87254', 1, 110, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');
    $pacienteEduardaAtualizado = new Paciente(1, 'Eduarda Matini', $cpfPaula, 1, 110, '2003-09-26', 'eduarda@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');
    $pacientePaula->setAddPaciente();
    $pacienteEduarda->setAddPaciente();
    $idPacienteEduarda = $pacienteEduarda->getIdPaciente();
    $this->assertContains($pacienteEduardaAtualizado->setAlteraPaciente($idPacienteEduarda), "Este CPF já está cadastrado!");
  }

  public function testSetAlteraPacienteUsuarioInexistente() {
    $idUsuarioInexistente = 999;
    $paciente = new Paciente($idUsuarioInexistente, 'Uelinton teske', '97744', 1, 110, '2002-09-26', 'ueliNton.teskE09@gmail.com', '1234567890', 'Rua tiradentes, 69', 'braço do trombudo', 'Sinusite');
    $idPaciente = $paciente->getIdPaciente();
    $this->assertContains($paciente->setAlteraPaciente($idPaciente), "Não foi possível atualizar o paciente!");
  }
}