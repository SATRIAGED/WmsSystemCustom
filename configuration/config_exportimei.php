<?php
include 'config_connect.php';
include 'xlsxwriter.class.php';
ini_set("memory_limit", "1024M");
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
$produk = $_GET['produk'];
$status = $_GET['status'];
$date1 = date("Y-m-d", strtotime($_GET['date1']));
$date2 = date("Y-m-d", strtotime($_GET['date2']));

if ($produk) {
    switch ($status) {
        case 'G':
            $where = "a.sku = 'SK" . $produk . "' and a.tgl_masuk >= '" . $date1 . "' and a.tgl_masuk <= '" . $date2 . "' and a.status_return = '" . $status . "'";
            $orderby = "order by a.tgl_masuk desc";
            break;
        case 'TK':
            $where = "a.sku = 'SK" . $produk . "' and a.tgl_keluar >= '" . $date1 . "' and a.tgl_keluar <= '" . $date2 . "' and a.status_return = '" . $status . "'";
            $orderby = "order by a.tgl_keluar desc";
            break;
        case 'K':
            $where = "a.sku = 'SK" . $produk . "' and a.tgl_return >= '" . $date1 . "' and a.tgl_return <= '" . $date2 . "' and a.status_return = '" . $status . "'";
            $orderby = "order by a.tgl_return desc";
            break;
        case 'R':
            $where = "a.sku = 'SK" . $produk . "' and a.tgl_return_ged >= '" . $date1 . "' and a.tgl_return_ged <= '" . $date2 . "' and a.status_return = '" . $status . "'";
            $orderby = "order by a.tgl_return_ged desc";
            break;
        default:
            $where = "a.sku = 'SK" . $produk . "' and a.tgl_masuk >= '" . $date1 . "' and a.tgl_masuk <= '" . $date2 . "'";
            $orderby = "order by a.tgl_masuk desc";
    }
} else {
    switch ($status) {
        case 'G':
            $where = "a.tgl_masuk >= '" . $date1 . "' and a.tgl_masuk <= '" . $date2 . "' and a.status_return = '" . $status . "'";
            $orderby = "order by a.tgl_masuk desc";
            break;
        case 'TK':
            $where = "a.tgl_keluar >= '" . $date1 . "' and a.tgl_keluar <= '" . $date2 . "' and a.status_return = '" . $status . "'";
            $orderby = "order by a.tgl_keluar desc";
            break;
        case 'K':
            $where = "a.tgl_return >= '" . $date1 . "' and a.tgl_return <= '" . $date2 . "' and a.status_return = '" . $status . "'";
            $orderby = "order by a.tgl_return desc";
            break;
        case 'R':
            $where = "a.tgl_return_ged >= '" . $date1 . "' and a.tgl_return_ged <= '" . $date2 . "' and a.status_return = '" . $status . "'";
            $orderby = "order by a.tgl_return_ged desc";
            break;
        default:
            $where = "a.tgl_masuk >= '" . $date1 . "' and a.tgl_masuk <= '" . $date2 . "'";
            $orderby = "order by a.tgl_masuk desc";
    }
}

$sql2    = "
SELECT 
a.sku, 
b.nama, 
date(a.tgl_masuk) AS tgl_masuk,
date(a.tgl_keluar) AS tgl_keluar,
date(a.tgl_return) AS tgl_return,
date(a.tgl_return_ged) AS tgl_return_ged,
a.nota_masuk,a.nota_keluar,a.imei1,a.imei2,a.sn,c.awb,a.status_return
FROM imei a 
LEFT JOIN barang b ON a.sku = b.sku 
LEFT JOIN stok_keluar c ON a.nota_keluar = c.nota
WHERE $where
$orderby";
$result = mysqli_query($conn, $sql2);

$filename = "Daftar IMEI dan SN " . $produk . " " . $date1 . "" . $date2 . ".xlsx";
header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');


$header = array(
    'SKU' => 'string',
    'Nama Barang' => 'string',
    'Tanggal Masuk GED' => 'string',
    'Tanggal Keluar GED' => 'string',
    'Tanggal Return XIA' => 'string',
    'Tanggal Kembali GED' => 'string',
    'Nota Masuk GED' => 'string',
    'Nota Keluar GED' => 'string',
    'IMEI 1' => 'string',
    'IMEI 2' => 'string',
    'SN' => 'string',
    'Airway Bill' => 'string',
    'Status' => 'string'
);


$writer = new XLSXWriter();
$writer->setAuthor('Some Author');
$writer->writeSheetHeader('Sheet1', $header);
while ($row = mysqli_fetch_array($result)) {
    $status = $row[12];
    $tglreturn = $row[4];
    if ($tglreturn) {
        if ($tglreturn = '0000-00-00') {
            $tglreturnconv = '';
        } else {
            $tglreturnconv = $tglreturn;
        }
    } else {
        $tglreturnconv = '';
    }
    switch ($status) {
        case 'TK':
            $statusconv = 'Tidak Dikembalikan';
            break;
        case 'K':
            $statusconv = 'Dikembalikan XIA';
            break;
        case 'R':
            $statusconv = 'Diterima GED';
            break;
        default:
            $statusconv = 'Digudang GED';
    }
    $writer->writeSheetRow('Sheet1', [
        $row[0],
        $row[1],
        $row[2],
        $row[3],
        $tglreturnconv,
        $row[5],
        $row[6],
        $row[7],
        $row[8],
        $row[9],
        $row[10],
        $row[11],
        $statusconv
    ]);
}
$writer->writeToStdOut();
exit(0);
