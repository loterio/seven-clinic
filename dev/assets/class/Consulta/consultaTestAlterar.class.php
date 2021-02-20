<?php
namespace Classes\Consulta;
use PHPUnit\Framework\TestCase;
require_once "consulta.class.php";

class ConsultaTesteAlterar extends TestCase 
{
  public function testSetAlteraConsulta() {
    $consulta = new Consulta(1, '2020-11-12', '11:00:00', '11:30:00', 120, 'ok', 1, 1, 0);
    $consulta->setAddConsulta();
    $consultaAtualizada = new Consulta(1, '2020-11-12', '10:00:00', '10:30:00', 120, 'ok', 1, 1, 0);
    $this->assertContains($consultaAtualizada->setAlteraConsulta(7), "Consulta atualizada com sucesso!");
  }

  public function testSetAlteraConsultaInexistente() {
    $idConsultaInexistente = 999;
    $consulta = new Consulta(1, '2021-10-12', '1:00:00', '2:00:00', 120, 'ok', 2, 2, 0);
    $consulta->setAddConsulta();
    $this->assertContains($consulta->setAlteraConsulta($idConsultaInexistente), "Não foi possível atualizar a consulta!");
  }

  public function testSetAlteraConsultaHorarioIndisposnível() {
    $consulta = new Consulta(1, '2021-10-12', '1:00:00', '2:00:00', 120, 'ok', 1, 1, 0);
    $consulta->setAddConsulta();
    $this->assertContains($consulta->setAlteraConsulta(2), ["Este horário já possui outra consulta agendada para este paciente!","Este horário já possui outra consulta agendada para este médico!"]);
  }
}