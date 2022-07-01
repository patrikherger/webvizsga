<?php

  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', 'root');
  define('DB_PASSWORD', '');
  define('DB_NAME', 'receptkonyv');

  $mysql_db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

  if (!$mysql_db) {
      die("Hiba az adatbázishoz való
            csatlakozás nem sikerült" . $mysql_db->connect_error);
  }
