<?php



function conectarDB() : mysqli {
	$db = mysqli_connect('localhost', 'root', '', 'to_do_list');

	if(!$db){
		echo "Error no se pudo conectar";

		exit;
	}

	return $db;
}