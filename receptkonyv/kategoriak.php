<?php

function mindent($mysql_db)
{
    $eredmeny = $mysql_db->query('SELECT id, kategoria FROM kategoriak ORDER BY id');



    $rows = array();
    while ($row = $eredmeny->fetch_assoc()) {
        $row_adat = array();
        $row_adat['id'] = $row['id'];
        $row_adat['kategoria'] = $row['kategoria'];
        array_push($rows, $row_adat);
    }
    return $rows;
}

require_once 'config/config.php';

$response = array();
if ($_GET['akcio'] == 'mindent') {
    $response['lista'] = mindent($mysql_db);
}

echo json_encode($response);

$mysql_db->close();
