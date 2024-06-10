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
        $qimei1 = 0;
        $qimei2 = 0;
        $qsn    = 0;
        if ($row['no_imei1'] != '-') {
            $resultimei1 = mysqli_query($conn, "SELECT a.id FROM imei a WHERE a.status_return = 'K' AND a.imei1 = '" . $row['no_imei1'] . "' AND a.tgl_return_ged IS NULL");
            $qimei1 = mysqli_num_rows($resultimei1);
            if ($qimei1 == 1) {
                $updateimei1 = mysqli_query($conn, "UPDATE imei SET status_return = 'R', tgl_return_ged = '" . date('Y-m-d') . "'  where status_return = 'K' AND imei1 = '" . $row['no_imei1'] . "' AND tgl_return_ged IS NULL");
            }
        } else {
            if ($row['no_imei2'] != '-') {
                $resultimei2 = mysqli_query($conn, "SELECT a.id FROM imei a WHERE a.status_return = 'K' AND a.imei2 = '" . $row['no_imei2'] . "' AND a.tgl_return_ged IS NULL");
                $qimei2 = mysqli_num_rows($resultimei1);
                if ($qimei2 == 1) {
                    $updateimei2 = mysqli_query($conn, "UPDATE imei SET status_return = 'R', tgl_return_ged = '" . date('Y-m-d') . "'  where status_return = 'K' AND imei2 = '" . $row['no_imei2'] . "' AND tgl_return_ged IS NULL");
                }
            } else {
                if ($row['no_sn'] != '-') {
                    $resultsn = mysqli_query($conn, "SELECT a.id FROM imei a WHERE a.status_return = 'K' AND a.sn = '" . $row['no_sn'] . "' AND a.tgl_return_ged IS NULL");
                    $qsn = mysqli_num_rows($resultsn);
                    if ($qsn == 1) {
                        $updatesn = mysqli_query($conn, "UPDATE imei SET status_return = 'R', tgl_return_ged = '" . date('Y-m-d') . "'  where status_return = 'K' AND sn = '" . $row['no_sn'] . "' AND tgl_return_ged IS NULL");
                    }
                }
            }
        }

        $sql[] = '("' . $row['kode_barang'] . '", "' . $row['no_imei1'] . '", "' . $row['no_imei2'] . '", "' . $row['nota'] . '", "' . date('Y-m-d') . '", "' . $usr . '", "G", "' . $row['no_sn'] . '")';
        $sql2[] = '("' . $row['kode_barang'] . '", "' . $row['no_imei1'] . '", "' . $row['no_imei2'] . '", "' . date('Y-m-d') . '", "' . $usr . '", "' . $row['no_sn'] . '")';
    }

    $result = mysqli_query($conn, 'INSERT INTO imei (sku, imei1, imei2, nota_masuk, tgl_masuk, userid, status_return, sn) VALUES ' . implode(',', $sql));
    $result2 = mysqli_query($conn, 'INSERT INTO imei_masuk (sku, imei1, imei2, tgl_masuk, userid, sn) VALUES ' . implode(',', $sql2));

    echo json_encode(['status' => 'Data Imei/SN telah ditambahkan!']);
}

exit;
