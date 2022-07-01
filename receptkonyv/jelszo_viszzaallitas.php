<?php

session_start();
if (!isset($_SESSION['bejelentkezve']) && $_SESSION['bejelentkezve'] !== false) {
    header('location: bejelentkezes.php');
    exit;
}

require_once 'config/config.php';

$new_jelszo = $confirm_jelszo = "";
$new_jelszo_err = $confirm_jelszo_err = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty(trim($_POST['new_jelszo']))) {
        $new_jelszo_err = 'Adj meg egy új jelszót';
    } elseif (strlen(trim($_POST['new_jelszo'])) < 6) {
        $new_jelszo_err = 'A jelszónak legalább 6 karakterből kell állnia.';
    } else {
        $new_jelszo = trim($_POST['new_jelszo']);
    }

    if (empty(trim($_POST['confirm_jelszo']))) {
        $confirm_jelszo_err = 'Erősitsd meg a jelszavad.';
    } else {
        $confirm_jelszo = trim($_POST['confirm_jelszo']);
        if (empty($new_jelszo_err) && ($new_jelszo != $confirm_jelszo)) {
            $confirm_jelszo_err = 'A két jelszó nem egyzik';
        }
    }

    if (empty($new_jelszo_err)&& empty($confirm_jelszo_err)) {
        $sql = 'UPDATE felhasznalok SET jelszo = ? WHERE id = ?';

        if ($stmt = $mysql_db->prepare($sql)) {
            $param_jelszo=password_hash($new_jelszo, jelszo_DEFAULT);
            $param_id = $_SESSION(['id']);

            $stmt -> bind_param("si", $param_jelszo, $param_id);

            if ($stmt-> execute()) {
                session_destroy();
                header('location: bejelentkezes.php');
                exit;
            } else {
                echo "Valami hiba történt, probald meg ujra...";
            }
            $stmt->close();
        }
        $mysql_db->close();
    }
}

?>

<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Jelszóváltoztatás</title>
    <link rel="stylesheet" href="formazas.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>
  <body>
    <main>
      <section class="container formazas">
          <h2 class="display-4">JELSZÓ MEGVÁLTOZTATÁS</h2>
        <p class="text-center">Töltsd ki az űrlapot a jelszavad megváltoztatásához.</p>
        <hr style="width:50%;height:2px;border-width:0;background-color:orange" >

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <div class="form-group">
            <label for="new_jelszo">Jelszó :</label>
            <input type="password" name="new_jelszo" class="form-control" id="new_jelszo" value="<?php echo $new_jelszo ?>">
            <span><?php echo $new_jelszo_err; ?></span>
          </div>
          <div class="form-group">
            <label for="confirm_jelszo"> Új Jelszó mégegyszer :</label>
            <input type="password" name="confirm_jelszo" class="form-control" id="confirm_jelszo" value="<?php echo $confirm_jelszo ?>">
            <span><?php echo $confirm_jelszo_err; ?></span>
          </div>
          <hr style="height:2px;border-width:0;background-color:orange" >
          <div class="form-group">
            <input type="submit" name="" value="MEGVÁLTOZTATOM" class="btn btn-block btn-warning">
            <a href="index.php" class="btn btn-block btn-danger">MÉGSEM</a>
          </div>
        </form>
      </section>
    </main>
  </body>
</html>
