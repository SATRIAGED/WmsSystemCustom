<?php
include 'config_connect.php';
include 'xlsxwriter.class.php';
ini_set("memory_limit", "1024M");
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
$divisi         = $_GET['divisi'];
$produk         = $_GET['produk'];
$date1          = date("Y-m-d", strtotime($_GET['date1']));
$date2          = date("Y-m-d", strtotime($_GET['date2']));
$typeexport     = $_GET['typeexport'];

if ($divisi || $divisi != "") {
    if ($divisi != 13) {
        $wheredivisi = "AND b.id_divisi = {$divisi}";
    } else {
        $wheredivisi = "";
    }
} else {
    $wheredivisi = "";
}
if ($produk || $produk != "") {
    $produkset = trim(str_replace("SK", "", trim($produk)));
    $whereproduk = "AND a.kodebarang = '{$produkset}'";
} else {
    $whereproduk = "";
}


if (trim($typeexport)) {
    switch (trim($typeexport)) {
        case 'Export All Product':
            $filename = "Laporan Stok Barang All.xlsx";
            $header = array(
                'SKU'           => 'string',
                'Nama Barang'   => 'string',
                'Lokasi'        => 'string',
                'Kategori'      => 'string',
                'Masuk'         => 'integer',
                'Keluar'        => 'integer',
                'Aktual'        => 'integer'
            );
            $sqldata    = "SELECT a.sku, a.nama, a.lokasi, a.kategori, a.terbeli, a.terjual, a.sisa FROM barang a ORDER BY a.no";
            $result     = mysqli_query($conn, $sqldata);
            break;
        case 'Export All Product Divisi':
            $filename = "Laporan Stok Barang All Divisi.xlsx";
            $header = array(
                'SKU'           => 'string',
                'Nama Barang'   => 'string',
                'Lokasi'        => 'string',
                'Kategori'      => 'string',
                'Divisi'        => 'string',
                'Masuk'         => 'integer',
                'Keluar'        => 'integer',
                'Aktual'        => 'integer'
            );
            $sqldata    = "
            SELECT bg.sku, a.nama, bg.lokasi, bg.kategori,
            IFNULL(c.divisi,'General') AS divisi,
            SUM(a.jumlah) AS jumlahmasuk,
            CASE WHEN b.id_divisi IS NULL 
                THEN IFNULL((SELECT SUM(skd.jumlah) FROM stok_keluar_daftar skd WHERE skd.id_divisi = 13 AND skd.kode_barang = a.kode_barang GROUP BY skd.kode_barang),0)
            ELSE
                IFNULL((SELECT SUM(skd.jumlah) FROM stok_keluar_daftar skd WHERE skd.id_divisi = c.id AND skd.kode_barang = a.kode_barang GROUP BY skd.kode_barang),0)
            END AS jumlahkeluar
            FROM stok_masuk_daftar a 
            LEFT JOIN so_num b ON a.nota = b.nota
            LEFT JOIN divisi c ON b.id_divisi = c.id
            LEFT JOIN barang bg ON a.kode_barang = bg.kode
            GROUP BY c.divisi,a.kode_barang
            ORDER BY a.kode_barang";
            $result = mysqli_query($conn, $sqldata);
            break;
        case 'Export All Aktivitas':
            $filename = "Laporan Stok Barang All Aktivitas.xlsx";
            $header = array(
                'Tanggal'       => 'string',
                'SKU'           => 'string',
                'Nama'          => 'string',
                'User'          => 'string',
                'Kegiatan'      => 'string',
                'Jumlah'        => 'integer',
                'Sisa'          => 'integer',
                'NoSO-NoIRF'    => 'string',
                'Divisi'        => 'string'
            );
            $sqldata    = "
            SELECT a.no, a.tgl, c.sku, c.nama, a.namauser, a.kegiatan, a.jumlah, a.sisa,
            IFNULL((SELECT so.no_so FROM so_num so WHERE so.nota = a.keterangan LIMIT 1),'-') AS nosoirf,
            (SELECT dis.divisi FROM divisi dis WHERE dis.id = ifnull(b.id_divisi,13) LIMIT 1) AS divisiname
            FROM mutasi a 
            LEFT JOIN so_num b ON a.keterangan = b.nota
            INNER join barang c on a.kodebarang=c.kode 
            WHERE a.kegiatan = 'stok masuk' AND a.tgl >= '{$date1}' AND a.tgl <= '{$date2}' {$wheredivisi} {$whereproduk}
            UNION
            SELECT a.no, a.tgl, c.sku, c.nama, a.namauser, a.kegiatan, a.jumlah, a.sisa,
            IFNULL((SELECT sk.no_irf FROM stok_keluar sk WHERE sk.nota = a.keterangan LIMIT 1),'-') AS nosoirf,
            (SELECT dis.divisi FROM divisi dis WHERE dis.id = ifnull(b.id_divisi,13) LIMIT 1) AS divisiname
            FROM mutasi a 
            LEFT JOIN stok_keluar_daftar b ON a.keterangan = b.nota
            INNER join barang c on a.kodebarang=c.kode
            WHERE a.kegiatan = 'stok keluar' AND a.tgl >= '{$date1}' AND a.tgl <= '{$date2}' {$wheredivisi} {$whereproduk}
            ORDER BY sku,no DESC";
            $result = mysqli_query($conn, $sqldata);
            break;
        case 'Export Aktivitas Stok Masuk':
            $filename = "Laporan Stok Barang Aktivitas Masuk.xlsx";
            $header = array(
                'Tanggal'       => 'string',
                'SKU'           => 'string',
                'Nama'          => 'string',
                'User'          => 'string',
                'Kegiatan'      => 'string',
                'Jumlah'        => 'integer',
                'Sisa'          => 'integer',
                'NoSO'          => 'string',
                'Divisi'        => 'string'
            );
            $sqldata    = "
                SELECT a.no, a.tgl, c.sku, c.nama, a.namauser, a.kegiatan, a.jumlah, a.sisa,
                IFNULL((SELECT so.no_so FROM so_num so WHERE so.nota = a.keterangan LIMIT 1),'-') AS nosoirf,
                (SELECT dis.divisi FROM divisi dis WHERE dis.id = ifnull(b.id_divisi,13) LIMIT 1) AS divisiname
                FROM mutasi a 
                LEFT JOIN so_num b ON a.keterangan = b.nota
                INNER join barang c on a.kodebarang=c.kode 
                WHERE a.kegiatan = 'stok masuk' AND a.tgl >= '{$date1}' AND a.tgl <= '{$date2}' {$wheredivisi} {$whereproduk}
                ORDER BY sku,no DESC";
            $result = mysqli_query($conn, $sqldata);
            break;
        case 'Export Aktivitas Stok Keluar':
            $filename = "Laporan Stok Barang Aktivitas Keluar.xlsx";
            $header = array(
                'Tanggal'       => 'string',
                'SKU'           => 'string',
                'Nama'          => 'string',
                'User'          => 'string',
                'Kegiatan'      => 'string',
                'Jumlah'        => 'integer',
                'Sisa'          => 'integer',
                'NoIRF'         => 'string',
                'Divisi'        => 'string'
            );
            $sqldata    = "
                SELECT a.no, a.tgl, c.sku, c.nama, a.namauser, a.kegiatan, a.jumlah, a.sisa,
                IFNULL((SELECT sk.no_irf FROM stok_keluar sk WHERE sk.nota = a.keterangan LIMIT 1),'-') AS nosoirf,
                (SELECT dis.divisi FROM divisi dis WHERE dis.id = ifnull(b.id_divisi,13) LIMIT 1) AS divisiname
                FROM mutasi a 
                LEFT JOIN stok_keluar_daftar b ON a.keterangan = b.nota
                INNER join barang c on a.kodebarang=c.kode
                WHERE a.kegiatan = 'stok keluar' AND a.tgl >= '{$date1}' AND a.tgl <= '{$date2}' {$wheredivisi} {$whereproduk}
                ORDER BY sku,no DESC, tgl desc";
            $result = mysqli_query($conn, $sqldata);
            break;
        case 'Export IMEI-SN':
            if ($divisi) {
                if ($divisi == 13) {
                    $wdivisi = "AND b.id_divisi IS NULL";
                } else {
                    $wdivisi = "AND b.id_divisi = {$divisi}";
                }
            } else {
                $wdivisi = "";
            }

            if ($produk) {
                $wsku = "AND a.sku = '{$produk}'";
            } else {
                $wsku = "";
            }

            $filename = "Laporan Data IMEI-SN Barang.xlsx";
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
            $sqldata    = "
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
            WHERE a.tgl_masuk >= '{$date1}' and a.tgl_masuk <= '{$date2}' {$wdivisi} {$wsku} 
            ORDER BY a.tgl_masuk ASC,b.no_so";
            $result = mysqli_query($conn, $sqldata);
            break;
        default:
            $typeexport = "Kosong";
            $filename = "Kosong.xlsx";
            $header = array();
            break;
    }
} else {
    $typeexport = "Kosong";
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
$writer->writeSheetHeader(trim($typeexport), $header, $stylesheader);
if (trim($typeexport)) {
    switch (trim($typeexport)) {
        case 'Export All Product':
            while ($row = mysqli_fetch_array($result)) {
                $writer->writeSheetRow(trim($typeexport), [
                    $row[0],
                    $row[1],
                    $row[2],
                    $row[3],
                    $row[4],
                    $row[5],
                    $row[6],
                ], $stylesbody);
            }
            break;
        case 'Export All Product Divisi':
            while ($row = mysqli_fetch_array($result)) {
                $writer->writeSheetRow(trim($typeexport), [
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
        case 'Export All Aktivitas':
            while ($row = mysqli_fetch_array($result)) {
                $writer->writeSheetRow(trim($typeexport), [
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
            break;
        case 'Export Aktivitas Stok Masuk':
            while ($row = mysqli_fetch_array($result)) {
                $writer->writeSheetRow(trim($typeexport), [
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
            break;
        case 'Export Aktivitas Stok Keluar':
            while ($row = mysqli_fetch_array($result)) {
                $writer->writeSheetRow(trim($typeexport), [
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
            break;
        case 'Export IMEI-SN':
            while ($row = mysqli_fetch_array($result)) {
                $writer->writeSheetRow(trim($typeexport), [
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
            break;
        default:
            break;
    }
}
$writer->writeToStdOut();
exit(0);
