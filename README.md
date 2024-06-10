# WMS System V1

Langkah Deployment

1. Buat folder sessions, dikarenakan di gitignore
2. setting session path pada file op.php, config_session.php dan config_session2.php seperti berikut ini_set('session.save_path','/home/ridho/2022/app_customer/warehouse_xiaomi/'); (directori mengikuti folder tersimpan)
3. setting juga confing_connect.php
4. Kasih akses 0777
5. Set Confing Connect sebagai berikut :

<?php

error_reporting(E_ALL ^ E_DEPRECATED);
$servername = "";
$username = "";
$password = "";
$dbname="";

      $koneksi = mysqli_connect('', '', '');
        $db = mysqli_select_db($koneksi ,$dbname);

	// Create connection
	global $conn;
	$conn = mysqli_connect($servername, $username, $password,$dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>
