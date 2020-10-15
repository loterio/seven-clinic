<button class="fechar" onclick="fechaFormulario()"><img src="../assets/img/fechar.svg" alt=""></button>
<h2 class="titulo">Agendamento</h2>
<form method="POST" action="agendamento.php" autocomplete="off">
  <div class="input input-grande">
    <label for="paciente">Paciente</label>
    <select name="paciente" id="paciente" required>
      <option disabled selected></option>
      <option value="Henrique">Henrique</option>
      <option value="Felipe">Felipe</option>
    </select>
  </div>

  <div class="input input-grande">
    <label for="medico">Médico</label>
    <select name="medico" id="medico" required>
      <option disabled selected></option>
      <option value="Henrique">Henrique</option>
      <option value="Felipe">Felipe</option>
    </select>
  </div>

  <div class="input input-grande">
    <label for="descricao">Descrição</label>
    <textarea id="descricao" name="descricao" required></textarea>
  </div>

  <div class="input input-pequeno">
    <label for="valor">Valor</label>
    <input type="number" name="valor" id="valor" required>
  </div>

  <div class="input input-pequeno">
    <label for="data">Data</label>
    <input type="date" name="data" id="data" required>
  </div>


  <div class="input input-pequeno">
    <label for="horario-inicio">Início da Consulta</label>
    <input type="time" id="horario-inicio" name="hora-inicio" required>
  </div>

  <div class="input input-pequeno">
    <label for="horario-final">Fim da Consulta</label>
    <input type="time" id="horario-final" name="hora-final" required>
  </div>

  <div class="botao-submit input-grande">
    <button type="submit" name="acao" value="agendar">Agendar</button>
    <!-- <input type="submit" value="Agendar"> -->
  </div>
</form>