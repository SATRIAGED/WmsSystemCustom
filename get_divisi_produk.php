<?php

include "configuration/config_connect.php";
$jumlah = 0;
$bayar = 0;

if (isset($_POST['divisi'])) {
    $divisi   = $_POST['divisi'];
    $arraytamp = [];

    if ($divisi == 13) {
        $query = "SELECT a.kode, a.sku, a.nama, a.sisa FROM barang a";
        $resultcount = mysqli_query($conn, $query);
        foreach ($resultcount as $key) {
            $arraytamp[] = array(
                'kode' => $key['kode'],
                'sku' => $key['sku'],
                'nama' => $key['nama'],
                'sisa' => $key['sisa']
            );
        }
        echo json_encode($arraytamp);
    } else {
        $query = "
        SELECT 
        c.kode, c.sku, c.nama, c.sisa
        FROM so_num a 
        LEFT JOIN stok_masuk_daftar b ON a.nota = b.nota
        LEFT JOIN barang c ON b.kode_barang = c.kode
        WHERE a.id_divisi = {$divisi}
        GROUP BY c.kode
        ";
        $resultcount = mysqli_query($conn, $query);
        foreach ($resultcount as $key) {
            $arraytamp[] = array(
                'kode' => $key['kode'],
                'sku' => $key['sku'],
                'nama' => $key['nama'],
                'sisa' => $key['sisa']
            );
        }
        echo json_encode($arraytamp);
    }
}
exit;
