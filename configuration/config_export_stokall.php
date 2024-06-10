<?php
include 'config_connect.php';
include 'xlsxwriter.class.php';
ini_set("memory_limit", "1024M");
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
$search = $_GET['search'];
$forward = $_GET['forward'];

if (isset($forward)) {
    switch ($forward) {
        case 'laporan_stok_barang_all':
            if (isset($search) || $search) {
                $where = "WHERE a.kode LIKE '%{$search}%' OR a.nama LIKE '%{$search}%' OR a.kategori LIKE '%{$search}%'";
            } else {
                $where = "WHERE a.kode LIKE '%{$search}%' OR a.nama LIKE '%{$search}%' OR a.kategori LIKE '%{$search}%'";
            }
            $filename = "Laporan Stok Barang All.xlsx";
            $header = array(
                'SKU' => 'string',
                'Nama Barang' => 'string',
                'Lokasi' => 'string',
                'Kategori' => 'string',
                'Masuk' => 'integer',
                'Keluar' => 'integer',
                'Aktual' => 'integer',
                'P' => 'integer',
                'L' => 'integer',
                'T' => 'integer',
                'CBM' => 'price'
            );
            $sqldata    = "
            SELECT a.sku, a.nama, a.lokasi, a.kategori, 
            a.terbeli, a.terjual, a.sisa, a.p, a.l, a.t,
            (((a.p*a.l*a.t)/1000000)*a.sisa) AS cbm
            FROM barang a
            {$where}
            ORDER BY a.no";
            $result = mysqli_query($conn, $sqldata);
            break;
        case 'laporan_stok_barang_all_division':
            $filename = "Laporan Stok Barang All.xlsx";
            $header = array(
                'SKU' => 'string',
                'Nama Barang' => 'string',
                'Lokasi' => 'string',
                'Kategori' => 'string',
                'Divisi' => 'string',
                'Masuk' => 'integer',
                'Keluar' => 'integer',
                'Aktual' => 'integer'
            );
            $sqldata    = "
            SELECT bg.sku, a.nama, 
            bg.lokasi, bg.kategori,
            IFNULL(c.divisi,'General') AS divisi,
            SUM(a.jumlah) AS jumlahmasuk,
            case when b.id_divisi IS NULL 
            then IFNULL((SELECT SUM(skd.jumlah) 
            FROM stok_keluar_daftar skd 
            WHERE skd.id_divisi = 13
            AND skd.kode_barang = a.kode_barang GROUP BY skd.kode_barang),0)
            ELSE
            IFNULL((SELECT SUM(skd.jumlah) 
            FROM stok_keluar_daftar skd 
            WHERE skd.id_divisi = c.id
            AND skd.kode_barang = a.kode_barang GROUP BY skd.kode_barang),0)
            END AS jumlahkeluar
            FROM stok_masuk_daftar a 
            LEFT JOIN so_num b ON a.nota = b.nota
            LEFT JOIN divisi c ON b.id_divisi = c.id
            LEFT JOIN barang bg ON a.kode_barang = bg.kode
            GROUP BY c.divisi,a.kode_barang
            ORDER BY a.kode_barang";
            $result = mysqli_query($conn, $sqldata);
            break;
        default:
            $forward = "Kosong";
            $filename = "Kosong.xlsx";
            $header = array();
            break;
    }
} else {
    $forward = "Kosong";
    $filename = "Kosong.xlsx";
    $header = array();
}



header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');

$stylesheader = array('font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'fill' => '#eee',  'border' => 'left,right,top,bottom', 'border-style' => 'thin');
$stylesbody = array('font' => 'Arial', 'font-size' => 10, 'border' => 'left,right,top,bottom', 'border-style' => 'thin');
$writer = new XLSXWriter();
$writer->setAuthor('Some Author');
$writer->writeSheetHeader($forward, $header, $stylesheader);
if (isset($forward)) {
    switch ($forward) {
        case 'laporan_stok_barang_all':
            while ($row = mysqli_fetch_array($result)) {
                $writer->writeSheetRow($forward, [
                    $row[0],
                    $row[1],
                    $row[2],
                    $row[3],
                    $row[4],
                    $row[5],
                    $row[6],
                    $row[7],
                    $row[8],
                    $row[9],
                    $row[10]
                ], $stylesbody);
            }
            break;
        case 'laporan_stok_barang_all_division':
            while ($row = mysqli_fetch_array($result)) {
                $writer->writeSheetRow($forward, [
                    $row[0],
                    $row[1],
                    $row[2],
                    $row[3],
                    $row[4],
                    $row[5],
                    $row[6],
                    ($row[5] - $row[6])
                ], $stylesbody);
            }
            break;
        default:
            break;
    }
}
$writer->writeToStdOut();
exit(0);
