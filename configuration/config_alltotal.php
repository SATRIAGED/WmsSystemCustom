<?php
include 'config_connect.php';
date_default_timezone_set("Asia/Jakarta");
$harisekarang = date('d');
$bulansekarang = date('m');

$tahunsekarang = date('Y');
$now = date('Y-m-d');
$bulanlalu = date('m', strtotime("-1 month"));
$tahunlalu = date('Y', strtotime("-1 year"));
$today = date('d-m-Y : H:i');

// Total Data1

$sqlx2 = "SELECT COUNT(userna_me) as data FROM user";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$datax1 = $row['data'];

// Total Data2

$sqlx2 = "SELECT COUNT(kode) as data FROM supplier";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$datax2 = $row['data'];

// Total Data3

$sqlx2 = "SELECT COUNT(kode) as data FROM barang";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$datax3 = $row['data'];



$sqlx2 = "SELECT COUNT(kode) as data FROM barang where sisa <= '" . mysqli_escape_string($conn, 1) . "' ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$datax4 = $row['data'];

$sqlx2 = "SELECT 
COUNT(a.sku) AS data 
FROM imei a 
LEFT JOIN barang b ON a.sku = b.sku
WHERE 
a.status_return IS NOT NULL AND
a.status_return = 'K' AND 
((DATEDIFF(a.tgl_return,date(NOW())) > 0) AND (DATEDIFF(a.tgl_return,DATE(NOW())) <= 3))";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$datax5 = $row['data'];


// Data Stok

$sqlx2 = "SELECT SUM(sisa) AS data FROM barang ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$stok1 = $row['data'];

$sqlx2 = "SELECT SUM(terjual) AS data FROM barang ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$stok2 = $row['data'];

$sqlx2 = "SELECT SUM(terbeli) AS data FROM barang ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$stok3 = $row['data'];

$sqlx2 = "SELECT COUNT(kode) AS data FROM barang ";
$hasilx2 = mysqli_query($conn, $sqlx2);
$row = mysqli_fetch_assoc($hasilx2);
$stok4 = $row['data'];
