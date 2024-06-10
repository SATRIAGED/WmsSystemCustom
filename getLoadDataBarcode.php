<?php

include "configuration/config_connect.php";

if (isset($_POST['barcode'])) {
    $barcode   = $_POST['barcode'];
    $query = "
    SELECT 
    a.sku,
    a.barcode,
    a.nama,
    a.lokasi,
    a.brand AS merek,
    a.kategori, 
    a.satuan,
    a.p, a.l, a.t, 
    ROUND((((a.p * a.l * a.t) / 1000000) * a.sisa),2) AS cbm,
    a.terbeli AS masuk, a.terjual AS keluar, a.sisa,
    a.avatar
    FROM barang a 
    WHERE a.barcode = '$barcode' LIMIT 1";
    $resultcount = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($resultcount);
    echo json_encode($row);
} else {
}
exit;
