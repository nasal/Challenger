<?php

switch($_GET['user']) {

	case 'logout':
		unset($_SESSION['username']);
		header('location: ./');

	case 'register':
		include('register.php');
		break;

	case 'profile':	
		include('user-profile.php');
		break;

	case 'login':
		include('login.php');
		break;

	default:
		if (isset($_SESSION['username'])) {
			include('user-profile.php');
		} else {
			include('login.php');
		}
}

?>