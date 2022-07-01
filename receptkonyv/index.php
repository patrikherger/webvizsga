<?php
session_start();

if (!isset($_SESSION['bejelentkezve']) && $_SESSION['bejelentkezve'] !== false) {
    header('location: bejelentkezes.php');

    exit;
}
 ?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Receptkönyv</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="formazas.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>

    <div class="text-right m-2">
      <a href="jelszo_viszzaallitas.php" class="btn btn-warning">JELSZÓ MEGVÁLTOZTATÁSA</a>
      <a href="kijelentkezes.php" class="btn btn-danger">KIJELENTKEZÉS</a>
    </div>

    <hr style="height:2px;border-width:0;background-color:gray">
    <div class=" jumbotron bg-fej text-center m-3">
      <h1>Recept kategóriák</h1>
    </div>
    <hr style="height:2px;border-width:0;background-color:gray">

    <div class="container">
      <div class="row m-5 text-center" id="kategoriak"></div>


      <div class="row p-1 m-3 text-center">
        <div class="col">
          <h2><a href="receptfeltoltes.html">RECEPTFELTÖLTÉS</a></h2>
        </div>
      </div>
    </div>

    <script src="kategoriak.js"></script>
</body>
</html>
