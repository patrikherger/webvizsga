function mindenAdat() {

  var kategoriak = document.querySelector("#kategoriak");
  fetch('kategoriak.php?akcio=mindent')
    .then(response => response.json())
    .then(data => {
      feldolgozas(data, kategoriak);
    });
}

function feldolgozas(data, kategoriak) {
  var tartalom = "";
  for (var i = 0; i < data.lista.length; i++) {
    tartalom += '<div class="col-sx-12 col-md-6 col-sm-6 col-lg-6 col-xl-6">';
    tartalom += '<h2><a href="etelek.php?akcio=' + data.lista[i].id + '&megnevezes=' + data.lista[i].kategoria + '">' + data.lista[i].kategoria + '</a></h2>';
    tartalom += '</div>';
  }
  kategoriak.innerHTML = tartalom;
}

mindenAdat();
