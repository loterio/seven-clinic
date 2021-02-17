$(document).ready(function(){
    $("#filtro").change(function() {
     var filtro = ($('#filtro option:selected').val());
     if ((filtro) == "D"){
        $("#hidden").css("display", "none");
        $("#busca").css("display", "none");
        $("#data").css("display", "inline");
      }else if ((filtro) == "P" || (filtro) == "M"){
        $("#hidden").css("display", "none");
        $("#busca").css("display", "inline");
        $("#data").css("display", "none");
      }else{
        $("#hidden").css("display", "inline");
        $("#busca").css("display", "none");
        $("#data").css("display", "none");
      }
    });
  });

function ApenasLetras(e, t) {
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        } else if (e) {
            var charCode = e.which;
        } else {
            return true;
        }
        if (
            (charCode == 32) ||
            (charCode > 64 && charCode < 91) || 
            (charCode > 96 && charCode < 123) ||
            (charCode > 191 && charCode <= 255) // letras com acentos
        ){
            return true;
        } else {
            return false;
        }
    } catch (err) {
        alert(err.Description);
    }
}

function ajaxDiv(url, idDiv){
    const div = document.querySelector("#"+idDiv);
    fetch(url)
    .then((resposta) => resposta.text()) 
    .then((html) => {
      div.innerHTML = html;
    })
}