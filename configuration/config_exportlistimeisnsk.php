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
        $wdivisi = "AND b.id_divisi IS NULL";
    } else {
        $wdivisi = "AND b.id_divisi = {$divisi}";
    }
} else {
    $wdivisi = "";
}
$sql2    = "
select
a.sku,
IFNULL(b.no_so,'-') AS no_so,
IFNULL(c.no_irf,'-') AS no_irf,
a.imei1,
a.imei2,
a.sn,
IFNULL(a.tgl_masuk,'-') AS masuk,
IFNULL(a.tgl_keluar,'-') AS keluar,
case when a.tgl_keluar IS NULL then 'Masuk'
ELSE 'Keluar' END AS status,
IFNULL(d.divisi,'General') AS divisi
FROM imei a 
LEFT JOIN so_num  b on a.nota_masuk = b.nota
LEFT JOIN stok_keluar c ON a.nota_keluar = c.nota
LEFT JOIN divisi d ON b.id_divisi = d.id
WHERE a.sku = '{$sk}' {$wdivisi} ORDER BY a.tgl_masuk ASC,b.no_so";
$result = mysqli_query($conn, $sql2);
$totrow  = mysqli_num_rows($result);

$sqlmasuk = "
SELECT COUNT(a.tgl_masuk) AS totalmasuk
FROM dbwr_xiaomi_ga.imei a 
LEFT JOIN so_num  b on a.nota_masuk = b.nota
WHERE a.sku = '{$sk}' AND a.nota_masuk IS NOT NULL {$wdivisi}";
$sqlkeluar = "
SELECT COUNT(a.tgl_keluar) AS totalkeluar
FROM dbwr_xiaomi_ga.imei a 
LEFT JOIN so_num  b on a.nota_masuk = b.nota
WHERE a.sku = '{$sk}' AND a.nota_masuk IS NOT NULL {$wdivisi}";
$resultmasuk = mysqli_query($conn, $sqlmasuk);
$resultkeluar = mysqli_query($conn, $sqlkeluar);
$valuemasuk = $resultmasuk->fetch_row()[0] ?? 0;
$valuekeluar = $resultkeluar->fetch_row()[0] ?? 0;
$valuetersedia = ($valuemasuk - $valuekeluar);

$filename = "List Data IMEI-SN " . $sk . ".xlsx";
header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');


$header = array(
    'SKU' => 'string',
    'No-SO' => 'string',
    'No-IRF' => 'string',
    'IMEI-1' => 'string',
    'IMEI-2' => 'string',
    'SN' => 'string',
    'Masuk' => 'string',
    'Keluar' => 'string',
    'Status' => 'string',
    'Divisi' => 'string'
);

$stylesheader = array('font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'fill' => '#eee',  'border' => 'left,right,top,bottom', 'border-style' => 'thin');
$stylesbody = array('font' => 'Arial', 'font-size' => 10, 'border' => 'left,right,top,bottom', 'border-style' => 'thin');
$stylesfooter = array('font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'halign' => 'right', 'fill' => '#eee',  'border' => 'left,right,top,bottom', 'border-style' => 'thin');
$writer = new XLSXWriter();
$writer->setAuthor('Some Author');
$writer->writeSheetHeader($sk, $header, $stylesheader);
while ($row = mysqli_fetch_array($result)) {
    $writer->writeSheetRow($sk, [
        $row[0],
        $row[1],
        $row[2],
        $row[3],
        $row[4],
        $row[5],
        $row[6],
        $row[7],
        $row[8],
        $row[9]
    ], $stylesbody);
}
$stokmasuk = array("Stok Masuk", " ", " ", " ", " ", " ", " ", " ", " ", $valuemasuk);
$stokkeluar = array("Stok Keluar", " ", " ", " ", " ", " ", " ", " ", " ", $valuekeluar);
$stoktersedia = array("Stok Tersedia", " ", " ", " ", " ", " ", " ", " ", " ", $valuetersedia);
$writer->markMergedCell($sk, $start_row = ($totrow + 1), $start_col = 0, $end_row = ($totrow + 1), $end_col = 8);
$writer->markMergedCell($sk, $start_row = ($totrow + 1), $start_col = 9, $end_row = ($totrow + 1), $end_col = 9);
$writer->writeSheetRow($sk, $stokmasuk, $stylesfooter); //write data
$writer->markMergedCell($sk, $start_row = ($totrow + 2), $start_col = 0, $end_row = ($totrow + 2), $end_col = 8);
$writer->markMergedCell($sk, $start_row = ($totrow + 2), $start_col = 9, $end_row = ($totrow + 2), $end_col = 9);
$writer->writeSheetRow($sk, $stokkeluar, $stylesfooter); //write data
$writer->markMergedCell($sk, $start_row = ($totrow + 3), $start_col = 0, $end_row = ($totrow + 3), $end_col = 8);
$writer->markMergedCell($sk, $start_row = ($totrow + 3), $start_col = 9, $end_row = ($totrow + 3), $end_col = 9);
$writer->writeSheetRow($sk, $stoktersedia, $stylesfooter); //write data

$writer->writeToStdOut();
exit(0);
