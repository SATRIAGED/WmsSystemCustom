<?php
include "configuration/config_connect.php";
include "configuration/config_include.php";
session();

if (isset($_POST['noirf']) && isset($_POST['notae'])) {

    $nota = mysqli_real_escape_string($conn, $_POST["notae"]);
    $keterangan = mysqli_real_escape_string($conn, $_POST["keterangan"]);
    $awb = mysqli_real_escape_string($conn, $_POST["awb"]);
    $modal = mysqli_real_escape_string($conn, $_POST["modal"]);
    $total = mysqli_real_escape_string($conn, $_POST["total"]);
    $noirf = mysqli_real_escape_string($conn, $_POST["noirf"]);
    $userrequest = mysqli_real_escape_string($conn, $_POST["user_request"]);

    $tgl = date('Y-m-d');
    $usr = $_SESSION['nouser'];
    $cab = '01';
    $kegiatan = "Stok Keluar";

    $namairf = $_FILES['fotoirf']['name'];
    $ukuranirf = $_FILES['fotoirf']['size'];
    $tipeirf = $_FILES['fotoirf']['type'];
    $tmp = $_FILES['fotoirf']['tmp_name'];
    $fileirf = "dist/upload/irf/" . $namairf;

    if ($namairf) {

        move_uploaded_file($tmp, $fileirf);
        $sql2 = "insert into stok_keluar values( '$nota','$cab','$tgl','customer','$usr','$keterangan','$modal','$total','','$awb','$fileirf','$noirf','$userrequest')";
        $insertan = mysqli_query($conn, $sql2);

        $mut = "UPDATE mutasi SET status='berhasil' WHERE keterangan='$nota' AND kegiatan='$kegiatan'";
        $muta = mysqli_query($conn, $mut);

        $status = 'Stok selesai dikeluarkan!';
    } else {
        $status = 'GAGAL, terjadi kesalahan!';
    }
    echo json_encode(['status' => $status]);
}

exit;
