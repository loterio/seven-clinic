<?php
use PHPUnit\Framework\TestCase;
require_once "usuario.class.php";

class UsuatioTesteAlterar extends TestCase 
{
    public function testUsuarioAlterar() {
      $usuario = new Usuario("henrique.10@gmail.com");
      $this->assertContains($usuario->setAlteraUsuario(1, 
      'Henrique Borges', '123456', '123456'),"Usuário atualizado com sucesso!");
    }

    public function testUsuarioAlterarComSenhaInvalidas() {
      $usuario = new Usuario("henrique.10@gmail.com");
      $this->assertContains($usuario->setAlteraUsuario(1, 
      'Henrique Borges', '125321', '106456'),"A senha e a confirmação de senha não coincidem!");
    }
}
?>




