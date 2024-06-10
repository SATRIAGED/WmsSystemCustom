<?php

include "configuration/config_connect.php";
include "configuration/config_include.php";
session();
$jumlah = 0;
$bayar = 0;

if (isset($_POST['dataimei'])) {
    $dataimei = $_POST['dataimei'];
    $usr = $_SESSION['nouser'];
    $sql = array();
    $sql2 = array();
    foreach ($dataimei as $row) {
        mysqli_query($conn, "UPDATE imei SET tgl_keluar = '" . date('Y-m-d') . "', status = 0, 
        nota_keluar = '" . $row['nota'] . "', 
        userid = '" . $usr . "',
        status_return = '" . $row['status_return'] . "',
        tgl_return = '" . $row['tgl_return'] . "' 
        WHERE sku = '" . $row['kode_barang'] . "' AND 
        imei1 = '" . $row['no_imei1'] . "' AND
        imei2 = '" . $row['no_imei2'] . "' AND
        sn = '" . $row['sn'] . "' AND
        tgl_keluar IS NULL AND
        status = 1 AND
        nota_keluar IS NULL");
        $sql2[] = '("' . $row['kode_barang'] . '", "' . $row['no_imei1'] . '", "' . $row['no_imei2'] . '", "' . date('Y-m-d') . '", "' . $usr . '", "' . $row['sn'] . '")';
    }

    $result = mysqli_query($conn, 'INSERT INTO imei_keluar (sku, imei1, imei2, tgl_keluar, userid, sn) VALUES ' . implode(',', $sql2));

    echo json_encode(['status' => 'Data Imei/SN telah dikeluarkan!']);
}

exit;
