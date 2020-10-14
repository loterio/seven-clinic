// ===============Cards=================

const cardData = document.querySelectorAll(".card-data")
const eventos = document.querySelectorAll(".eventos-data");

cardData.forEach((card, index) => {
  card.addEventListener('click', ()=> {
    eventos[index].classList.toggle('ativo');
  })
})

// ===============Perfil================
let mostrarOpcoesPerfil = true;
const opcoesPerfil = document.querySelector(".perfil");

document.addEventListener('click', function(event) {
  let clicouNoPerfil = opcoesPerfil.contains(event.target);

  if (!clicouNoPerfil) {
    opcoesPerfil.classList.toggle("ativo", false);
    mostrarOpcoesPerfil = true;
  }else {
    opcoesPerfil.classList.toggle("ativo", mostrarOpcoesPerfil);
    mostrarOpcoesPerfil = !mostrarOpcoesPerfil;
  }
});

// ===============Add===================
let mostrarOpcoesAdd = true;
const botaoAdd = document.querySelector(".botao-add");
const opcoesAdd = document.querySelector(".add")

document.addEventListener('click', function(event) {
  let clicouNoAdd = botaoAdd.contains(event.target);

  if (!clicouNoAdd) {
    opcoesAdd.classList.toggle("ativo", false);
    mostrarOpcoesAdd = true;
  }else {
    opcoesAdd.classList.toggle("ativo", mostrarOpcoesAdd);
    mostrarOpcoesAdd = !mostrarOpcoesAdd;
  }
});

// ================Menu==================

let mostrarMenu = true;

const menuTogle = document.querySelector(".menu-togle")
const menu = document.getElementsByTagName("sidenav")
const fundoEscuro = document.querySelector(".fundo-escuro")

document.body.onresize = function() {
  if (document.body.clientWidth >= 768) {
    menu[0].style.display = 'initial';
    fundoEscuro.style.display = 'none';
  }
  if (document.body.clientWidth < 768) {
    menu[0].style.display = 'none';
  }
};

menuTogle.addEventListener("click", () => {
  menu[0].style.display = 'initial';
  fundoEscuro.style.display = 'initial';
  mostrarMenu = false;
});

fundoEscuro.addEventListener("click", () => {
  if (mostrarMenu == false) {
    menu[0].style.display = 'none';
    fundoEscuro.style.display = 'none';
    mostrarMenu = true;
  }
  console.log("Fundo escuro apertado")
});

//============Formularios=============
const botoesAdd = document.querySelectorAll(".add li button")

botoesAdd.forEach(
  botao => botao.addEventListener('click', 
  () => mostraFormulario() 
  )
);
function mostraFormulario() {
  const fundoEscuro = document.querySelector(".fundo-escuro");
  const espacoFormulario = document.querySelector(".espaco-formulario");
  fundoEscuro.style.display = 'initial';
  espacoFormulario.style.display = 'initial';
}

function fechaFormulario() {
  const fundoEscuro = document.querySelector(".fundo-escuro");
  const espacoFormulario = document.querySelector(".espaco-formulario");
  const div = document.querySelector("#espaco-formulario");

  fundoEscuro.style.display = 'none';
  espacoFormulario.style.display = 'none';
  div.innerHTML = "";
}

