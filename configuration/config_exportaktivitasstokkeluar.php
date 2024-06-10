<?php
include 'config_connect.php';
include 'xlsxwriter.class.php';
ini_set("memory_limit", "1024M");
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
$sk = $_GET['sk'];
$divisi = $_GET['divisi'];

if ($divisi) {
    if ($divisi == 13) {
        $wdivisi = "AND a.id_divisi IS NULL";
    } else {
        $wdivisi = "AND a.id_divisi = {$divisi}";
    }
} else {
    $wdivisi = "";
}

$sql2    = "
SELECT  
a.nota,
CONCAT('SK',a.kode_barang) AS kode_barang, 
a.nama,
a.jumlah,
IFNULL(sk.no_irf,'-') AS no_irf,
IFNULL(sk.user_request,'-') AS user_request,
IFNULL(b.divisi,'General') AS divisi
FROM stok_keluar_daftar a
LEFT JOIN stok_keluar sk ON a.nota = sk.nota
LEFT JOIN divisi b ON b.id = a.id_divisi
WHERE CONCAT('SK',a.kode_barang) = '{$sk}' {$wdivisi}";
$result = mysqli_query($conn, $sql2);

$filename = "Trans Barang Keluar SK" . $sk . ".xlsx";
header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');


$header = array(
    'Nota' => 'string',
    'Kode Barang' => 'string',
    'Nama Barang' => 'string',
    'Jumlah' => 'string',
    'No IRF' => 'string',
    'User' => 'string',
    'Divisi' => 'string'
);


$writer = new XLSXWriter();
$writer->setAuthor('Some Author');
$writer->writeSheetHeader($sk, $header);
while ($row = mysqli_fetch_array($result)) {
    $writer->writeSheetRow($sk, [
        $row[0],
        $row[1],
        $row[2],
        $row[3],
        $row[4],
        $row[5],
        $row[6],
        $row[7]
    ]);
}
$writer->writeToStdOut();
exit(0);
