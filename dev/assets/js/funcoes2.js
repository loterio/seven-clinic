// ================Menu==========================

const buttonMenuToggle = document.getElementById('button-menu-toggle');
buttonMenuToggle.addEventListener('click', menuToggle);
function menuToggle() {
  const menu = document.getElementById('menu');
  if (menu.style.display == 'none')
    menu.style.display = 'block';
  else
    menu.style.display = 'none';
}

// ==============================================