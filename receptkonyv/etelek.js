function mindenAdat() {

  var etelek = document.querySelector("#etelek");
  fetch('etelek_lekerdez.php?kategoria=' + kategoria)
    .then(response => response.json())
    .then(data => {
      feldolgozas(data, etelek);
    });
}

function feldolgozas(data, etelek) {
  var tartalom = "";
  for (var i = 0; i < data.lista.length; i++) {
    tartalom += '<div class="col-sx-12 col-md-6 col-sm-6 col-lg-6 col-xl-6">';
    tartalom += '<h2>' + data.lista[i].etel + '</a></h2>';
    tartalom += '</div>';
  }
  etelek.innerHTML = tartalom;
}

mindenAdat();
