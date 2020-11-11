<?php

require_once('funcoes.php');
iniciaSession();

class Usuario  
{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $confSenha;

    public function __construct($email){
        $this->setEmail($email);
    }

    public function setEmail($email){
        $this->email = mb_strtolower($email,'UTF-8');
    }

    public function setNome($nome){
        $this->nome = mb_strtoupper($nome,'UTF-8');
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function setConfSenha($confSenha){
        $this->confSenha = $confSenha;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getVerificaEmail($op){
        if ($op == TRUE) {
            $sql = 'SELECT COUNT(*) AS usuariosEmail FROM usuarios WHERE email = :email AND id != :id;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id' => $this->id,
                ':email' => $this->email
            );
        }else{
            $sql = 'SELECT COUNT(*) AS usuariosEmail FROM usuarios WHERE email = :email;';
            $stmt = preparaComando($sql);
            $bind = array(
                ':id' => $this->id,
                ':email' => $this->email
            );
        }
        $stmt = bindExecute($stmt, $bind);
        return $stmt->fetch(PDO::FETCH_ASSOC)['usuariosEmail'];
    }
    
    public function setAlteraUsuario($id, $nome, $senha, $confSenha){
        $this->setId($id);
        $this->setNome($nome);
        $this->setSenha($senha);
        $this->setConfSenha($confSenha);
        
        $countEmailUsusarios = $this->getVerificaEmail(TRUE);
        $msg = '';
        
        if ($this->senha === $this->confSenha) {
            $senha_cript=hash('sha512',$this->senha);
            
            if ($countEmailUsusarios == 0) {
                $sql = 'UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE id = :id;';
                $stmt = preparaComando($sql);
                $bind = array(
                    ':id' => $this->id,
                    ':nome' => $this->nome,
                    ':email' => $this->email,
                    ':senha' => $senha_cript
                );
                $stmt = bindExecute($stmt, $bind);
                
                if( $stmt->rowCount() > 0 ) {
                    // echo ('Usuário atualizado com sucesso!');
                    $msg = 'Usuário atualizado com sucesso!';
                    // $_SESSION['msg'] = "Usuário atualizado com sucesso!";
                    // header('location:perfil.php?status=OK');
                } else {
                    // echo ('Não foi possível atualizar o usuário!');
                    $msg = 'Não foi possível atualizar o usuário!';
                    // $_SESSION['msg'] = "Não foi possível atualizar o usuário!";
                    // header('location:perfil.php?status=ERRO');
                }
            }else {
                // echo ('Este e-mail já está cadastrado!');
                $msg = 'Este e-mail já está cadastrado!';
                // $_SESSION['msg'] = "Este e-mail já está cadastrado!";
                // header('location:perfil.php?status=ERRO');
            }  
        }else {
            // echo ('A senha e a confirmação de senha não coincidem!');
            $msg = 'A senha e a confirmação de senha não coincidem!';
            // $_SESSION['msg'] = "A senha e a confirmação de senha não coincidem!";
            // header('location:perfil.php?status=ERRO');
        }
        return $msg;
    }
   
}


?>