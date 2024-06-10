<?php
include "configuration/config_connect.php";
include "configuration/config_include.php";
session();

if (isset($_POST['noso']) && isset($_POST['notae'])) {
    $supplier = $_POST['supplier'];
    $noso = $_POST['noso'];
    $divisi = $_POST['divisi'];

    $user_request = $_POST['user_request'];
    $notae = $_POST['notae'];

    $tgl        = date('Y-m-d');
    $usr        = $_SESSION['nouser'];
    $cab        = '01';
    $kegiatan   = "Stok Masuk";

    $namabarang = $_FILES['foto_barang']['name'];
    $ukuranbarang = $_FILES['foto_barang']['size'];
    $tipebarang = $_FILES['foto_barang']['type'];
    $tmp = $_FILES['foto_barang']['tmp_name'];
    $filebarang = "dist/upload/so/" . $namabarang;

    $namabarangso = $_FILES['foto_so']['name'];
    $ukuranbarangso = $_FILES['foto_so']['size'];
    $tipebarangso = $_FILES['foto_so']['type'];
    $tmpso = $_FILES['foto_so']['tmp_name'];
    $filebarangso = "dist/upload/so/" . $namabarangso;

    if ($namabarang) {
        move_uploaded_file($tmp, $filebarang);
        move_uploaded_file($tmpso, $filebarangso);
        $sql2       = "insert into stok_masuk values( '$notae','$cab','$tgl','$supplier','$usr','')";
        $insertan   = mysqli_query($conn, $sql2);

        $sqlso      = "INSERT INTO so_num (no_so, nota, id_divisi, user_request,foto_barang,foto_so) VALUES ('{$noso}','{$notae}',{$divisi},'{$user_request}','{$filebarang}','{$filebarangso}')";
        $insertanso = mysqli_query($conn, $sqlso);

        $mut        = "UPDATE mutasi SET status='berhasil' WHERE keterangan='$notae' AND kegiatan='stok masuk'";
        $muta       = mysqli_query($conn, $mut);

        $status = 'Stok selesai dimasukan!';
    } else {
        $status = 'Gagal, terjadi keselahan!';
    }
    echo json_encode(['status' => $status]);
}

exit;
