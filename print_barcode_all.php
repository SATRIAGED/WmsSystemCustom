<?php
include "configuration/config_connect.php";

$kolom = 2;  // jumlah kolom

$counter = 1;
// sql query ke database

$sql_barcode = "SELECT sku,barcode,nama FROM barang order by no";
$baca_barcode = mysqli_query($conn, $sql_barcode);
//menampilkan hasil generate barcode

echo "<table style=\"width:100%\">";
while ($data = mysqli_fetch_array($baca_barcode)) {

    if (($counter - 1) % $kolom == '0') {
        echo "<tr>";
    }

    echo "<td style=\"padding: 15px; text-align: center;\">";
    echo "<strong><u>{$data['nama']}</u></strong>";
    echo '<img style="width: 95%;" class="barcode" alt="' . $data['barcode'] . '" src="barcode.php?text=' . $data['barcode'] . '&codetype=code128&orientation=horizontal&size=30&print=true"/>';
    "</td>";

    if ($counter % $kolom == '0') {
        echo "</tr>";
    }
    $counter++;
}
echo "</table>";
