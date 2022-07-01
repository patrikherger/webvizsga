<?php

function mindent($mysql_db)
{
    $valasztott = $_GET['kategoria'];

    $stmt = $mysql_db->prepare("SELECT id, etel FROM etelek WHERE kategoriaid =?");
    $stmt->bind_param("i", $valasztott);
    $stmt->execute();
    $eredmeny = $stmt->get_result();



    $rows = array();
    while ($row = $eredmeny->fetch_assoc()) {
        $row_adat = array();
        $row_adat['id'] = $row['id'];
        $row_adat['etel'] = $row['etel'];
        array_push($rows, $row_adat);
    }
    return $rows;
}

require_once 'config/config.php';

$response = array();

    $response['lista'] = mindent($mysql_db);

echo json_encode($response);

$mysql_db->close();
