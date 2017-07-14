<?php
	require("conexion.php");
	$auto =@$_POST["placas"];
	$fecha =@$_POST["fecha"];
	$kilometraje =@$_POST["kilometraje"];
	$subtotal =@$_POST["subtotal"];
	$observaciones =@$_POST["observaciones"];
	
	$sql = "SELECT count(*) as num FROM Orden;";
	$consulta = $conn->query($sql);
	$r = $consulta->fetch_assoc();
	$num = $r["num"] + 1;
	
	$folio  =  "OS";
	$folio .= str_pad($num, 5, "0", STR_PAD_LEFT); 
	
	$sql = "INSERT INTO Orden VALUES('$folio','$auto',$kilometraje,'$fecha',$subtotal,'$observaciones');";
	$conn->query($sql);
	
	$numT =@$_POST["numTrabajos"];
	for($i = 1; $i <= $numT; $i++){
		$descripcion =@$_POST["t".$i];
		$mano =@$_POST["mo".$i];
		$refacciones =@$_POST["r".$i];
		
		$sql = "INSERT INTO Trabajo(descripcion, manoObra, refacciones, ordenPresupuesto) VALUES('$descripcion',$mano,$refacciones,'$folio');";
		$conn->query($sql);
	}
	
	header("Location: orden.php?folio=".$folio);
?>
