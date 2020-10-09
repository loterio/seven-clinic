let mostrarOpcoesPerfil = true;
let mostrarOpcoesAdd = true;
let mostrarMenu = true;

const opcoesPerfil = document.querySelector(".perfil");
const botaoAdd = document.querySelector(".botao-add");
const opcoesAdd = document.querySelector(".add")
const cardData = document.querySelectorAll(".card-data");
const eventos = document.querySelectorAll(".eventos-data");
const menuTogle = document.querySelector(".menu-togle")
const menu = document.getElementsByTagName("sidenav")
const fundoEscuro = document.querySelector(".fundo-escuro")

cardData.forEach((card, index) => {
  card.addEventListener('click', ()=> {
    eventos[index].classList.toggle('ativo');
  })
})

document.addEventListener('click', function(event) {
  let clicouMenuTogle = menuTogle.contains(event.target);
  if (!clicouMenuTogle) {
    let windowWidth = window.innerWidth;
    if (windowWidth <= 768) {
      menu[0].style.display = 'none';
      fundoEscuro.style.display = 'none';
    }
  } else {
    menu[0].style.display = 'initial';
    fundoEscuro.style.display = 'initial';
  }
});


document.addEventListener('click', function(event) {
  let clicouNoPerfil = opcoesPerfil.contains(event.target);
  let clicouNoAdd = botaoAdd.contains(event.target);

  if (!clicouNoPerfil) {
    opcoesPerfil.classList.toggle("ativo", false);
    mostrarOpcoesPerfil = true;
  }else {
    opcoesPerfil.classList.toggle("ativo", mostrarOpcoesPerfil);
    mostrarOpcoesPerfil = !mostrarOpcoesPerfil;
  }

  if (!clicouNoAdd) {
    opcoesAdd.classList.toggle("ativo", false);
    mostrarOpcoesAdd = true;
  }else {
    opcoesAdd.classList.toggle("ativo", mostrarOpcoesAdd);
    mostrarOpcoesAdd = !mostrarOpcoesAdd;
  }
});