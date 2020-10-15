<button class="fechar" onclick="fechaFormulario()"><img src="../assets/img/fechar.svg" alt=""></button>
<h2 class="titulo">Médico</h2>
<form method="POST" action="agendamento.php" autocomplete="off">
  <div class="input input-grande">
    <label for="nome">Nome</label>
    <input type="text" id="nome" name="nome" maxlength="45" required>
  </div>

  <div class="input input-pequeno">
    <label for="crm">CRM</label>
    <input type="text" id="crm" name="crm" required>
  </div>
  <div class="input input-pequeno">
    <label for="telefone">Telefone</label>
    <input type="text" id="telefone" name="telefone" required>
  </div>

  <div class="input input-grande">
    <label for="especializacao">Expecialização</label>
    <input type="text" id="especializacao" name="especializacao" maxlength="45" required>
  </div>

  <div class="botao-submit input-grande">
    <button type="submit" name="acao" value="addMedico">Adicionar</button>
    <!-- <input type="submit" value="Adicionar" name="acao"> -->
  </div>
</form>