<?php
	session_start();
	session_unset();
	session_destroy();
	header("Location: https://gamecave.com/index.php");
	exit();
?>
