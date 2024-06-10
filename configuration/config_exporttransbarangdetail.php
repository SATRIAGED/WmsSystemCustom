<?php
include 'config_connect.php';
include 'xlsxwriter.class.php';
ini_set("memory_limit", "1024M");
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
$no = $_GET['no'];
$divisi = $_GET['divisi'];
$sql = "SELECT kode from barang where no = '$no' ";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($query);
$kodesku = $data['kode'];

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
SELECT 
a.no,
a.tgl,
c.sku,
c.nama,
a.namauser,
a.kegiatan,
a.jumlah,
a.sisa,
IFNULL((SELECT so.no_so FROM so_num so WHERE so.nota = a.keterangan LIMIT 1),'-') AS nosoirf
FROM mutasi a 
LEFT JOIN so_num b ON a.keterangan = b.nota
inner join barang c on a.kodebarang=c.kode 
WHERE a.kodebarang = '{$kodesku}' AND a.kegiatan = 'stok masuk' {$wdivisi}
union
SELECT 
a.no,
a.tgl,
c.sku,
c.nama,
a.namauser,
a.kegiatan,
a.jumlah,
a.sisa,
IFNULL((SELECT sk.no_irf FROM stok_keluar sk WHERE sk.nota = a.keterangan LIMIT 1),'-') AS nosoirf
FROM mutasi a 
LEFT JOIN stok_keluar_daftar b ON a.keterangan = b.nota
inner join barang c on a.kodebarang=c.kode
WHERE a.kodebarang = '{$kodesku}' AND a.kegiatan = 'stok keluar' {$wdivisi}
ORDER BY NO desc";
$result = mysqli_query($conn, $sql2);

$filename = "Trans Barang SK" . $kodesku . ".xlsx";
header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');


$header = array(
    'Tanggal' => 'string',
    'SKU' => 'string',
    'Barang' => 'string',
    'User' => 'string',
    'Aktivitas' => 'string',
    'Jumlah' => 'string',
    'Stok' => 'string',
    'SO/IRF' => 'string'
);


$writer = new XLSXWriter();
$writer->setAuthor('Some Author');
$writer->writeSheetHeader('SK' . $kodesku, $header);
while ($row = mysqli_fetch_array($result)) {
    $writer->writeSheetRow('SK' . $kodesku, [
        $row[1],
        $row[2],
        $row[3],
        $row[4],
        $row[5],
        $row[6],
        $row[7],
        $row[8],
        $row[9],
    ]);
}
$writer->writeToStdOut();
exit(0);
