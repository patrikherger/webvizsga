<?php

  require_once 'config/config.php';

  $felhasznalonev = $jelszo = $confirm_jelszo = "";
  $felhasznalonev_err = $jelszo_err = $confirm_jelszo_err = "";

  if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
      if (empty(trim($_POST['felhasznalonev']))) {
          $felhasznalonev_err = "Add meg a felhasználó nevedet";
      } else {
          $sql ='SELECT id FROM felhasznalok WHERE felhasznalonev = ?';

          if ($stmt = $mysql_db->prepare($sql)) {
              $param_felhasznalonev = trim($_POST['felhasznalonev']);
              $stmt -> bind_param('s', $param_felhasznalonev);

              if ($stmt->execute()) {
                  $stmt->store_result();

                  if ($stmt->num_rows == 1) {
                      $felhasznalonev_err = "Ez a felhasználónév már foglalt.";
                  } else {
                      $felhasznalonev = trim($_POST['felhasznalonev']);
                  }
              } else {
                  echo "Valami hiba történt, próbáld meg újra...";
              }
          } else {
              $mysql_db->close();
          }
      }
      if (empty(trim($_POST['jelszo']))) {
          $jelszo_err = "Adjon meg egy jelszót.";
      } elseif (strlen(trim($_POST['jelszo'])) < 6) {
          $jelszo_err = "AA jelszó legalább 6 karakter kell lennie.";
      } else {
          $jelszo = trim($_POST['jelszo']);
      }

      if (empty(trim($_POST['confirm_jelszo']))) {
          $confirm_jelszo_err = "Erősítse meg egy jelszót";
      } else {
          $confirm_jelszo = trim($_POST['confirm_jelszo']);
          if (empty($jelszo_err) && ($jelszo != $confirm_jelszo)) {
              $confirm_jelszo_err = "A két jelszó nem egyezik.";
          }
      }

      if (empty($felhasznalonev_err) && empty($jelszo_err) && empty($confirm_jelszo_err)) {
          $sql = 'INSERT INTO felhasznalok (felhasznalonev, jelszo, jog) VALUES (?,?, 2)';
          if ($stmt = $mysql_db->prepare($sql)) {
              $param_felhasznalonev = $felhasznalonev;
              $param_jelszo = jelszo_hash($jelszo, jelszo_DEFAULT);

              $stmt -> bind_param('ss', $param_felhasznalonev, $param_jelszo);

              if ($stmt -> execute()) {
                  header('location: ./bejelentkezes.php');
              } else {
                  echo "Valami hiba történt, próbáld meg újra...";
              }
              $stmt -> close();
          }
          $mysql_db -> close();
      }
  }

?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="formazas.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>
  <body>
    <main>
      <section class="container formazas">
        <h2 class="display-4 pt-3">Regisztráció</h2>
        <p class="text-center">Add meg a hitelesítő adatait</p>
        <hr>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <div class="form-group">
            <label for="felhasznalonev">Felhasználónév:</label>
            <input type="text" name="felhasznalonev" id="felhasznalonev" value="<?php echo $felhasznalonev; ?>" class="form-control">
            <span ><?php echo $felhasznalonev_err; ?></span>
          </div>

          <div class="form-group">
            <label for="jelszo">Jelszó:</label>
            <input type="password" name="jelszo" id="jelszo" value="<?php echo $jelszo; ?>" class="form-control">
            <span ><?php echo $jelszo_err; ?></span>
          </div>

          <div class="form-group">
            <label for="confirm_jelszo">Jelszó megerősítés:</label>
            <input type="password" name="confirm_jelszo" id="confirm_jelszo" value="<?php echo $confirm_jelszo; ?>" class="form-control">
            <span ><?php echo $confirm_jelszo_err; ?></span>
          </div>

          <div class="form-group">
            <input type="submit" name="" value="Regisztráció" class="btn btn-block btn-outline-success">
            <input type="reset" name="" value="Visszaállítás" class="btn btn-block btn-outline-danger">
          </div>
          <p>Van már fiókod? <a href="bejelentkezes.php">Jelentkezz be.</a> </p>

        </form>

      </section>
    </main>
  </body>
</html>
