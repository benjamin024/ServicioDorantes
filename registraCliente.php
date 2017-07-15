<?php
	require("conexion.php");
	$nombre =@$_POST["nombre"];
	$apellidos =@$_POST["apellidos"];
	$telefono =@$_POST["telefono"];
	$email =@$_POST["email"];
	
	$sql = "SELECT count(*) as num FROM Cliente;";
	$consulta = $conn->query($sql);
	$num = 0;
	while($r = $consulta->fetch_assoc()){
		$num = $r["num"];
	}
	$num++;
	
	$folio  = strtoupper(substr($apellidos, 0, 2));
	$folio .= strtoupper($nombre[0]);
	$folio .= str_pad($num, 4, "0", STR_PAD_LEFT); 
	
	$sql = "INSERT INTO Cliente VALUES('$folio','$nombre','$apellidos','$telefono','$email');";
	$conn->query($sql);
	
	header("Location: cliente.php?id=$folio");

?>
