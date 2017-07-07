<?php
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "taller";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$acentos = $conn->query("SET NAMES 'utf8'");
	// Check connection
	if ($conn->connect_error) {
	    die("Falló la Conexión: " . $conn->connect_error);
	}
?>
