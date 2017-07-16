<?php
	$folio =@$_GET["folio"];
	$mail =@$_GET["mail"];
	require("conexion.php");

	$sql = "SELECT a.marca, a.submarca FROM Auto as a, Orden as o WHERE o.auto = a.placas AND o.folio = '$folio';";
	$consulta = $conn->query($sql);
	$r = $consulta->fetch_assoc();
	$asunto = "Orden de Servicio de ".$r["marca"]." ".$r["submarca"];
	
	require_once('AttachMailer.php'); 
	$mailer = new AttachMailer("servicio_dorantes@hotmail.com", $mail, $asunto, "Adjunto orden de servicio en formato PDF.");
	$mailer->attachFile("temp/$folio.pdf");
	if($mailer->send()){
		unlink("temp/$folio.pdf");
		echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
	}else{
		include("menu.php");
		echo "<div class='containter'><div class='row'><div class='col-md-8 col-md-offset-2'><center><br><br><span style='font-size: 2.2em; font-weight: bold;'>Ocurrió un error al enviar, intenta más tarde</span></center></div></div></div>";
	}
		
?>
