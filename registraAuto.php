<?php
	require("conexion.php");
	$placas =@$_POST["placas"];
	$marca =@ $_POST["marca"];
	$submarca =@$_POST["submarca"];
	$modelo =@$_POST["modelo"];
	$cliente =@$_POST["cliente"];
	
	$placas = str_replace("-","",$placas);
	$placas = str_replace(" ","",$placas);
	$placas = strtoupper($placas);
	
	$sql = "INSERT INTO Auto VALUES('$placas','$marca','$submarca','$modelo','$cliente');";
	
	$conn->query($sql);
	
	header("Location: cliente.php?id=$cliente");
?>
