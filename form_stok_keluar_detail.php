<?php
include "configuration/config_connect.php";
include "configuration/config_include.php";
session();

if (isset($_POST['nota']) && isset($_POST['kode'])) {
    $halaman = "stok_out"; // halaman
    $totalscan = mysqli_real_escape_string($conn, $_POST["totalscan"]);
    $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);

    $divisi = mysqli_real_escape_string($conn, $_POST["divisi"]);
    $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
    $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
    $hbeli = mysqli_real_escape_string($conn, $_POST["hargabeli"]);
    $hjual = mysqli_real_escape_string($conn, $_POST["hargajual"]);
    $stok = mysqli_real_escape_string($conn, $_POST["stok"]);

    $kegiatan = "Stok Keluar";
    $status = "pending";
    $usr = $_SESSION['nama'];
    $today = date('Y-m-d');
    if ($jumlah <= $stok) {

        $brg = mysqli_query($conn, "SELECT * FROM barang WHERE kode='$kode'");
        $ass = mysqli_fetch_assoc($brg);
        $oldstok = $ass['sisa'];
        $oldout = $ass['terjual'];
        $newstok = $oldstok - $jumlah;
        $newout = $oldout + $jumlah;

        $sqlx = "UPDATE barang SET sisa='$newstok', terjual='$newout' WHERE kode='$kode'";
        $updx = mysqli_query($conn, $sqlx);
        if ($updx) {

            $sql = "select * from stok_keluar_daftar where nota='$nota' and kode_barang='$kode'";
            $resulte = mysqli_query($conn, $sql);

            if (mysqli_num_rows($resulte) > 0) {
                $q = mysqli_fetch_assoc($resulte);
                $cart = $q['jumlah'];
                $newcart = $cart + $jumlah;
                $total = $newcart * (($hjual) ? $hjual : 0);
                $modal = $newcart * (($hbeli) ? $hbeli : 0);


                $sqlu = "UPDATE stok_keluar_daftar SET jumlah='$newcart', subbeli='$modal', subtotal='$total' where nota='$nota' AND kode_barang='$kode'";
                $ucart = mysqli_query($conn, $sqlu);
                if ($ucart) {
                    $status = 'Jumlah Stok keluar telah ditambah!';
                } else {
                    $status = 'GAGAL, Periksa kembali input anda!';
                }
            } else {

                $total = $jumlah * (($hjual) ? $hjual : 0);
                $modal = $jumlah * (($hbeli) ? $hbeli : 0);

                $sql2 = "insert into stok_keluar_daftar values( '$nota','$kode','$nama','$jumlah','$modal','$total','','$divisi')";
                $insertan = mysqli_query($conn, $sql2);

                if ($insertan) {

                    $sql9 = "INSERT INTO mutasi VALUES('$usr','$today','$kode','$newstok','$jumlah','stok keluar','$nota','','pending')";
                    $mutasi = mysqli_query($conn, $sql9);

                    $status = 'Produk telah dimasukan dalam daftar!';
                } else {
                    $status = 'GAGAL memasukan produk, periksa kembali!';
                }
            }
        } else {
            $status = 'Gagal mengupdate jumlah stok!';
        }
    } else {
        $status = 'Jumlah keluar tidak boleh lebih besar dari stok tersedia!';
    }

    echo json_encode(['status' => $status]);
}

exit;
