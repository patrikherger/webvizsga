<?php
session_start();

if (!isset($_SESSION['bejelentkezve']) && $_SESSION['bejelentkezve'] !== false) {
    header('location: bejelentkezes.php');
    exit;
}

$kat = isset($_GET['megnevezes']) ? $_GET['megnevezes'] : '';
$katid = isset($_GET['akcio']) ? $_GET['akcio'] : '';
?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <script type="text/javascript">
      var kategoria = '<?php echo $katid; ?>';
    </script>
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
      <h1>
        <?php

        echo $kat;
         ?>
      </h1>

    </div>
    <hr style="height:2px;border-width:0;background-color:gray">

  <div class="container">
    <div class="row  text-center p-2 m-3" id="etelek"></div>
  </div>

    <div class="text-right p-3 m-3">
        <a href="index.php" class="btn btn-primary">VISSZA</a>
    </div>

<script src="etelek.js"></script>
</body>
</html>
