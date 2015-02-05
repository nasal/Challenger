<?php

switch($_GET['challenge']) {

	case 'show':
		include('challenge-show.php');
		break;

	case 'category':
		include('challenge-category.php');
		break;

	case 'create':
		include('challenge-create.php');
		break;

	default: 
		include('challenge-main.php');

}

?>