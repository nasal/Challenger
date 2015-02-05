<?php
if (isset($_SESSION['username'])) {
	include('browse.php');
}
else {
	include('login.php');
}
?>