<?php
include "configuration/config_connect.php";
include "configuration/config_include.php";
session();

if (isset($_POST['nota']) && isset($_POST['kode'])) {
    $halaman = "stok_in"; // halaman
    $totalscan = mysqli_real_escape_string($conn, $_POST["totalscan"]);
    $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);

    $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
    $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);

    $kegiatan = "Stok Masuk";
    $status = "pending";
    $usr = $_SESSION['nama'];
    $today = date('Y-m-d');

    $brg = mysqli_query($conn, "SELECT * FROM barang WHERE kode='$kode'");
    $ass = mysqli_fetch_assoc($brg);
    $oldstok = $ass['sisa'];
    $oldin = $ass['terbeli'];
    $newstok = $oldstok + $jumlah;
    $newin = $oldin + $jumlah;

    $sqlx = "UPDATE barang SET sisa='$newstok', terbeli='$newin' WHERE kode='$kode'";
    $updx = mysqli_query($conn, $sqlx);
    if ($updx) {

        $sql = "select * from stok_masuk_daftar where nota='$nota' and kode_barang='$kode'";
        $resulte = mysqli_query($conn, $sql);

        if (mysqli_num_rows($resulte) > 0) {
            $q = mysqli_fetch_assoc($resulte);
            $cart = $q['jumlah'];
            $newcart = $cart + $jumlah;
            $sqlu = "UPDATE stok_masuk_daftar SET jumlah='$newcart' where nota='$nota' AND kode_barang='$kode'";
            $ucart = mysqli_query($conn, $sqlu);
            if ($ucart) {

                //            $sql3 = "UPDATE mutasi SET jumlah='$newcart' WHERE keterangan='$nota' AND kegiatan='$kegiatan' ";
                //            $upd=mysqli_query($conn,$sql3);
                $status = 'Jumlah Stok masuk telah ditambah!';
            } else {
                $status = 'GAGAL, Periksa kembali input anda!';
            }
        } else {

            $sql2 = "insert into stok_masuk_daftar values( '$nota','$kode','$nama','$jumlah','')";
            $insertan = mysqli_query($conn, $sql2);

            if ($insertan) {

                $sql9 = "INSERT INTO mutasi VALUES('$usr','$today','$kode','$newstok','$jumlah','stok masuk','$nota','','pending')";
                $mutasi = mysqli_query($conn, $sql9);

                $status = 'Produk telah dimasukan dalam daftar!';
            } else {
                $status = 'GAGAL memasukan produk, periksa kembali!';
            }
        }
    } else {
        $status = 'Gagal mengupdate jumlah stok!';
    }

    echo json_encode(['status' => $status]);
}

exit;
