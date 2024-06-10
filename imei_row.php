<?php

include "configuration/config_connect.php";
$jumlah = 0;
$bayar = 0;

if (isset($_POST['nomorsku']) && isset($_POST['nomorimei']) && isset($_POST['modulview']) && isset($_POST['divisi']) && isset($_POST['produk'])) {
    $nomorsku   = $_POST['nomorsku'];
    $nomorimei  = $_POST['nomorimei'];
    $modulview  = $_POST['modulview'];
    $divisi     = $_POST['divisi'];
    $produk     = $_POST['produk'];

    if ($divisi == 13) {
        $qurso = "AND b.no_so IS NULL";
    } else {
        $qurso = "AND b.id_divisi = {$divisi} AND b.no_so IS NOT NULL";
    }

    if ($modulview == 'viewrowbarangkeluar') {
        $query = "
        SELECT count(a.sku) as totalskuimei 
        FROM imei a
        LEFT JOIN so_num b on b.nota = a.nota_masuk 
        WHERE 
        a.sku = '{$nomorsku}' 
        AND a.tgl_keluar IS NULL 
        AND a.status = 1 
        AND a.nota_keluar IS NULL 
        {$qurso}
        AND (UPPER(a.imei1) = UPPER('{$nomorimei}') 
        OR UPPER(a.imei2) = UPPER('{$nomorimei}')
        OR UPPER(a.sn) = UPPER('{$nomorimei}')) LIMIT 1";
        $resultcount = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($resultcount);

        if ($row[0] == 1) {
            $query = "
            SELECT a.sku, a.imei1, a.imei2, a.sn 
            FROM imei a 
            LEFT JOIN so_num b on b.nota = a.nota_masuk
            WHERE 
            a.sku = '{$nomorsku}' 
            AND a.tgl_keluar IS NULL 
            AND a.status = 1 
            AND a.nota_keluar IS NULL 
            {$qurso}
            AND (UPPER(a.imei1) = UPPER('{$nomorimei}') 
            OR UPPER(a.imei2) = UPPER('{$nomorimei}') 
            OR UPPER(a.sn) = UPPER('{$nomorimei}')) LIMIT 1";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_array($result)) {
                $response[] = array("sku" => $row['sku'], "imei1" => $row['imei1'], "imei2" => $row['imei2'], "sn" => $row['sn']);
            }

            echo json_encode($response);
        } else {
            $response[] = array("sku" => 'Kosong', "imei1" => 'Kosong', "imei2" => 'Kosong', "sn" => 'Kosong');
            echo json_encode($response);
        }
    } else {
        $arrayimei = explode(",", $nomorimei);
        $arrayimeicount = count($arrayimei);
        if ($arrayimeicount == 1) {
            $query = "SELECT count(a.sku) as totalskuimei FROM imei a 
            WHERE a.sku = '" . $nomorsku . "' AND
            a.tgl_keluar IS NULL AND
            a.status = 1 AND
            a.nota_keluar IS NULL AND
            (UPPER(a.imei1) = UPPER('" . $arrayimei[0] . "') 
            OR UPPER(a.imei2) = UPPER('" . $arrayimei[0] . "')
            OR UPPER(a.sn) = UPPER('" . $arrayimei[0] . "')) 
            LIMIT 1";
            $resultcount = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($resultcount);

            if ($row[0] == 0) {
                $response[] = array("sku" => 'Kosong');
                echo json_encode($response);
            } else {
                $response[] = array("sku" => 'Ada');
                echo json_encode($response);
            }
        } else {
            $query = "SELECT count(a.sku) as totalskuimei FROM imei a 
            WHERE a.sku = '" . $nomorsku . "' AND
            a.tgl_keluar IS NULL AND
            a.status = 1 AND
            a.nota_keluar IS NULL AND
            UPPER(a.imei1) = UPPER('" . $arrayimei[0] . "') AND
            UPPER(a.sn) = UPPER('" . $arrayimei[1] . "')
            LIMIT 1";
            $resultcount = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($resultcount);

            if ($row[0] == 0) {
                $response[] = array("sku" => 'Kosong');
                echo json_encode($response);
            } else {
                $response[] = array("sku" => 'Ada');
                echo json_encode($response);
            }
        }
    }
}
exit;
