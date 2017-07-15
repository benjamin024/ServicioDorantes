<?php
	require("conexion.php");
	$titulo =@$_POST["titulo"];
	$fecha =@$_POST["fecha"];
	$subtotal =@$_POST["subtotal"];
	$notas =@$_POST["notas"];
	
	$sql = "SELECT count(*) as num FROM Presupuesto;";
	$consulta = $conn->query($sql);
	$r = $consulta->fetch_assoc();
	$num = $r["num"] + 1;
	
	$folio  =  "PRE";
	$folio .= str_pad($num, 4, "0", STR_PAD_LEFT); 
	
	$sql = "INSERT INTO Presupuesto VALUES('$folio','$titulo','$fecha',$subtotal,'$notas');";
	$conn->query($sql);
	
	$numT =@$_POST["numTrabajos"];
	for($i = 1; $i <= $numT; $i++){
		$descripcion =@$_POST["t".$i];
		$mano =@$_POST["mo".$i];
		$refacciones =@$_POST["r".$i];
		
		$sql = "INSERT INTO Trabajo(descripcion, manoObra, refacciones, ordenPresupuesto) VALUES('$descripcion',$mano,$refacciones,'$folio');";
		$conn->query($sql);
	}
	
	header("Location: presupuesto.php?folio=".$folio);
?>
