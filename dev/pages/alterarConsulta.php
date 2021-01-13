<button class="fechar" onclick="fechaFormulario()"><img src="../assets/img/fechar.svg" alt=""></button>
<h2 class="titulo">Agendamento</h2>
<form method="GET" action="" autocomplete="off">
  <div class="input input-grande">
    <label for="paciente">Paciente</label>
    <select name="paciente" id="paciente">
      <option value="Henrique">Henrique</option>
      <option value="Felipe">Felipe</option>
    </select>
  </div>
  <div class="input input-grande">
    <label for="medico">Médico</label>
    <select name="medico" id="medico">
      <option value="Henrique">Henrique</option>
      <option value="Felipe">Felipe</option>
    </select>
  </div>
  <div class="input input-grande">
    <label for="descricao">Descrição</label>
    <textarea id="descricao"></textarea>
  </div>
  <div class="input input-pequeno">
    <label for="valor">Valor</label>
    <input type="number" id="valor">
  </div>
  <div class="input input-pequeno">
    <label for="data">Data</label>
    <input type="date" id="data">
  </div>
  <div class="input input-pequeno">
    <label for="horario-inicio">Início da Consulta</label>
    <input type="time" id="horario-inicio">
  </div>
  <div class="input input-pequeno">
    <label for="horario-final">Fim da Consulta</label>
    <input type="time" id="horario-final">
  </div>
  <div class="botao-submit input-grande">
    <input type="submit" value="Agendar">
  </div>
</form>