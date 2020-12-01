<?php
  use PHPUnit\Framework\TestCase;
  require_once "consulta.class.php";

class ConsultaTesteAdd extends TestCase 
{

  public function testSetAddConsultaNovo() {
    $consulta = new Consulta(1, '2020-11-12', '06:00:00', '08:30:00', 120, 'ok', 1, 1, 0);
    $this->assertContains($consulta->setAddConsulta(), "Consulta cadastrada com sucesso!");
  }

  public function testSetAddConsultaUsuarioInexistente() {
    $idUsuarioInexistente = 999;
    $consulta = new Consulta($idUsuarioInexistente, '2020-11-11', '06:00:00', '08:30:00', 120, 'ok', 1, 1, 0);
    $this->assertContains($consulta->setAddConsulta(), "Erro ao adicionar consulta!");
  }

  public function testSetAddConsultaHorarioOcupadoMedico() {
    $idMedico = 1;
    $primeiraConsulta = new Consulta(1, '2020-11-1', '08:00:00', '08:30:00', 120, 'ok', 1, $idMedico, 0);
    $segundaConsulta = new Consulta(1, '2020-11-1', '08:00:00', '08:30:00', 120, 'ok', 2, $idMedico, 0);
    $primeiraConsulta->setAddConsulta();
    $this->assertContains($segundaConsulta->setAddConsulta(), "Este horário já possui outra consulta agendada para este médico!");
  }

  public function testSetAddConsultaHorarioOcupadoPaciente() {
    $idPaciente = 1;
    $primeiraConsulta = new Consulta(1, '2020-10-11', '08:00:00', '08:30:00', 120, 'ok', $idPaciente, 1, 0);
    $segundaConsulta = new Consulta(1, '2020-10-11', '08:00:00', '08:30:00', 120, 'ok', $idPaciente, 2, 0);
    $primeiraConsulta->setAddConsulta();
    $this->assertContains($segundaConsulta->setAddConsulta(), "Este horário já possui outra consulta agendada para este paciente!");
  }
}


