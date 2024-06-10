<?php
include "configuration/config_connect.php";

$kolom = $_POST['kolom'];  // jumlah kolom

if ($_POST['jumlah'] == "") {
    $copy = "1";
} else {
    $copy = $_POST['jumlah'];
} // jumlah copy barcode

$barcode = $_POST['barcode'];
$kode = $_POST['kode'];
$counter = 1;
// sql query ke database

$sql_barcode = "SELECT nama FROM barang WHERE barcode='$barcode' limit 1";
$baca_barcode = mysqli_query($conn, $sql_barcode);
$data_barcode = mysqli_fetch_assoc($baca_barcode);
//menampilkan hasil generate barcode

echo "<table style=\"width:100%\">";
for ($ucopy = 1; $ucopy <= $copy; $ucopy++) {
    if (($counter - 1) % $kolom == '0') {
        echo "<tr>";
    }
    echo "<td style=\"padding: 15px; text-align: center;\">";
    echo "<strong><u>{$data_barcode['nama']}</u></strong>";
    echo '<img style="width: 100%;" class="barcode" alt="' . $_POST['barcode'] . '" src="barcode.php?text=' . $_POST['barcode'] . '&codetype=code128&orientation=horizontal&size=30&print=true"/>';
    // echo bar128(stripslashes($_POST['barcode']));
    "</td>";
    if ($counter % $kolom == '0') {
        echo "</tr>";
    }
    $counter++;
}
echo "</table>";
