
<?php
// ini_set('session.save_path','/home/ridho/WmsSystemV1/sessions/');
session_start();
if (!(isset($_SESSION['username']))) {

	// remove all session varibles
	session_unset();
	// destroy the session
	session_destroy();
	header("Location: login");
}

?>
