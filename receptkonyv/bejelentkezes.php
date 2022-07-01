<?php

session_start();

if (isset($_SESSION["bejelentkezve"]) && $_SESSION["bejelentkezve"] === true) {
    header('location: index.php');
    exit;
}
  require_once 'config/config.php';

  $felhasznalonev = $jelszo = '';
  $felhasznalonev_err = $jelszo_err = '';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (empty(trim($_POST['felhasznalonev']))) {
          $felhasznalonev_err = 'Add meg a felhasználóneved.';
      } else {
          $felhasznalonev = trim($_POST['felhasznalonev']);
      }

      if (empty(trim($_POST['jelszo']))) {
          $jelszo_err = 'Add meg a jelszavadat.';
      } else {
          $jelszo = trim($_POST['jelszo']);
      }

      if (empty($felhasznalonev_err) && empty($jelszo_err)) {
          $sql = 'SELECT id, felhasznalonev, jelszo, jog FROM felhasznalok WHERE felhasznalonev=?';

          if ($stmt = $mysql_db->prepare($sql)) {
              $param_felhasznalonev = $felhasznalonev;
              $stmt -> bind_param('s', $param_felhasznalonev);

              if ($stmt->execute()) {
                  $stmt->store_result();
                  if ($stmt->num_rows == 1) {
                      $stmt->bind_result($id, $felhasznalonev, $hashed_jelszo, $jog);
                      if ($stmt->fetch()) {
                          if (password_verify($jelszo, $hashed_jelszo)) {
                              session_start();
                              $_SESSION['bejelentkezve'] = true;
                              $_SESSION['id'] = $id;
                              $_SESSION['felhasznalonev'] = $felhasznalonev;
                              $_SESSION['jog'] = $jog;

                              header('location: index.php');
                          } else {
                              $jelszo_err = 'Helytelen jelszó.';
                          }
                      }
                  } else {
                      $felhasznalonev_err = 'A felhasználónév nem létezik';
                  }
              } else {
                  echo "Valami hiba történt, próbáld meg újra";
              }
              $stmt-> close();
          }
          $mysql_db->close();
      }
  }

?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="formazas.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>
  <body>
    <main>
      <section class="container formazas">
        <h2 class="display-4 pt-3">BELÉPÉS</h2>
        <p class="text-center">Add meg az adataidat a belépéshez</p>

        <hr style="width:50%;height:2px;border-width:0;background-color:blue" >
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <div class="form-group">
            <label for="felhasznalonev">Felhasználónév : </label>
            <input type="text" name="felhasznalonev" class="form-control" id="felhasznalonev" value="<?php echo $felhasznalonev ?>">
            <span><?php echo $felhasznalonev_err; ?></span>
          </div>
          <div class="form-group">
            <label for="jelszo">Jelszó : </label>
            <input type="password" name="jelszo" class="form-control" id="jelszo" value="<?php echo $jelszo ?>">
            <span><?php echo $jelszo_err; ?></span>
          </div>
          <hr style="height:2px;border-width:0;background-color:blue">

          <div class="form-group">
            <input type="submit" class="btn btn-block btn-outline-success" value="BELÉPÉS">
          </div>
          <p>Nincs még fiókod ? <a href="regisztracio.php">REGISZTRÁLJ !</a> </p>
        </form>
      </section>
    </main>
  </body>
</html>
