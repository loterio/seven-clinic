<button class="fechar" onclick="fechaFormulario()"><img src="../assets/img/fechar.svg" alt=""></button>
<h2 class="titulo">Paciente</h2>
<form method="POST" action="agendamento.php" autocomplete="off">
  <div class="input input-grande">
    <label for="nome">Nome</label>
    <input type="text" id="nome" onkeypress="return ApenasLetras(event,this);" title="Não é permitido números e/ou caracteres especiais." pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" name="nome" required>
  </div>

  <div class="input input-pequeno">
    <label for="cpf">CPF</label>
    <input type="text" id="cpf" name="cpf" required>
  </div>
  <div class="input input-pequeno">
    <label for="altura">Altura</label>
    <input type="text" id="altura" name="altura" required>
  </div>

  <div class="input input-pequeno">
    <label for="peso">Peso</label>
    <input type="text" id="peso" name="peso" required>
  </div>
  <div class="input input-pequeno">
    <label for="nascimento">Data de Nascimento</label>
    <input type="date" id="nascimento" name="nascimento" required>
  </div>

  <div class="input input-pequeno">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>
  </div>
  <div class="input input-pequeno">
    <label for="telefone">Telefone</label>
    <input type="text" id="telefone" name="telefone" required>
  </div>

  <div class="input input-pequeno">
    <label for="endereco">Endereço</label>
    <input type="text" id="endereco" name="endereco" required>
  </div>
  <div class="input input-pequeno">
    <label for="cidade">Cidade</label>
    <input type="text" id="cidade" name="cidade" required>
  </div>

  <div class="input input-grande">
    <label for="observacoes">Observações</label>
    <textarea id="observacoes" name="observacoes"></textarea>
  </div>

  <div class="botao-submit input-grande">
    <button type="submit" name="acao" value="addPaciente">Adicionar</button>
    <!-- <input type="submit" value="Adicionar"> -->
  </div>
</form>