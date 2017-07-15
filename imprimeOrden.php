<?php
	require("conexion.php");
	$folio =@$_GET["folio"];
	
	$sql = "SELECT * FROM Orden WHERE folio='$folio';";
	$orden = $conn->query($sql);
	$ro = $orden->fetch_assoc();
	$sql = "SELECT a.placas, a.marca, a.submarca, a.modelo, a.cliente, c.nombre, c.apellido, c.telefono, c.email FROM Auto as a, Cliente as c WHERE a.cliente = c.IDCliente AND a.placas = '".$ro["auto"]."';";
	$data = $conn->query($sql);
	$d = $data->fetch_assoc();
	setlocale(LC_TIME, 'es_MX.UTF-8');
	$fecha = strftime("Ciudad de México a %d de %B de %G",strtotime($ro["fecha"]));
	
	use Dompdf\Dompdf;
	require_once("dompdf/autoload.inc.php");
	$dompdf = new DOMPDF();
	$html = "
		<html>
		  <head><title>Orden de Servicio</title></head>
		  <body style='color: #007ED2;'>
		  	 <p style='text-align: right; color: red; font-size: 12px;'>$folio</p>
		  	 <table style='width: 100%;'>
			    	<tr>
			    		<td style='width: 33.33%;'><img src='img/Logo.jpg' width='200px'></td>
			    		<td style='width: 33.33%;'><h3>SERVICIO DORANTES</h3></td>
			    		<td style='width: 33.33%;font-size: 11px'>
				    		<center>
					    		<b>Orden de Servicio</b><br>
					    		Ing. Benjamín Dorantes Pérez<br>
				    			RFC: DOPB670906259<br>
				    			Lago Musters No. 74 Col. Argentina Antigua, Miguel Hidalgo, Ciudad de México. C.P.: 11270<br>
							Teléfono: 55277025<br>
							Celular: 5523380682<br>
							Email: servicio_dorantes@hotmail.com
				    		</center>
			    		</td>
			    			
			    	</tr>
		   	 </table><br><br>
		   	 <b>Nombre: </b><u>".$d["nombre"]." ".$d["apellido"]."</u><br>
		   	 <b>Teléfono: </b><u>".$d["telefono"]."</u><br>
		   	 <b>Correo Electrónico: </b><u>".$d["email"]."</u><br><br>
		   	 <table style='border: 1px solid; border-collapse: collapse; width: 100%; text-align: center;'>
				<thead>
					<tr>
						<th style='border: 1px solid; border-bottom: hidden; text-align: center; width: 20%;'>Marca</th>
						<th style='border: 1px solid; border-bottom: hidden; text-align: center; width: 20%;'>Submarca</th>
						<th style='border: 1px solid; border-bottom: hidden; text-align: center; width: 20%;'>Modelo / año</th>
						<th style='border: 1px solid; border-bottom: hidden; text-align: center; width: 20%;'>Placas</th>
						<th style='border: 1px solid; border-bottom: hidden; text-align: center; width: 20%;'>Kilometraje</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style='border: 1px solid; border-top: hidden;'>".$d["marca"]."</td>
						<td style='border: 1px solid; border-top: hidden;'>".$d["submarca"]."</td>
						<td style='border: 1px solid; border-top: hidden;'>".$d["modelo"]."</td>
						<td style='border: 1px solid; border-top: hidden;'>".$d["placas"]."</td>
						<td style='border: 1px solid; border-top: hidden;'>".$ro["kilometraje"]." Km</td>
					</tr>
				</tbody>
			</table><br>
			<table style='border: 1px solid; border-collapse: collapse; width: 100%; border-bottom: hidden; text-align: center;'>
				<thead>
					<tr>
						<th style='border: 1px solid; text-align: center; width: 50%;'>Descripción del trabajo</th>
						<th style='border: 1px solid; text-align: center; width: 16.66%;'>Mano de Obra</th>
						<th style='border: 1px solid; text-align: center; width: 16.66%;'>Refacciones</th>
						<th style='border: 1px solid; text-align: center; width: 16.66%;'>Total</th>
					</tr>
				</thead>
				<tbody>";
				$sql = "SELECT * FROM Trabajo WHERE ordenPresupuesto = '".$ro["folio"]."';";
				$trabajos = $conn->query($sql);
				$num = 1;
				while($r = $trabajos->fetch_assoc()){
					$html .= "<tr><td style='border: 1px solid;'>".$r["descripcion"]."</td>";
					$html .= "<td style='border: 1px solid;'>$".$r["manoObra"]."</td>";
					$html .= "<td style='border: 1px solid;'>$".$r["refacciones"]."</td>";
					$html .= "<td style='border: 1px solid;'>$".($r["manoObra"] + $r["refacciones"])."</td></tr>";
					$num++;
				}
				for($i = $num; $i <= 10; $i++){
					$html .= "<tr>
							<td style='border: 1px solid;'>&nbsp;</td>
							<td style='border: 1px solid;'>&nbsp;</td>
							<td style='border: 1px solid;'>&nbsp;</td>
							<td style='border: 1px solid;'>&nbsp;</td>
						  </tr>";
				}
	$html .="		</tbody>
			</table>
			<table style='border: 1px solid; border-collapse: collapse; width: 100%; text-align: center;'>
		        	<tr style='border-top: hidden;'>
						<td  style='border: 1px solid; width: 66.66%;' rowspan=3' valign='top'><b>Notas extra</b></td>
						<td  style='border: 1px solid; width: 16.66%;'><b>Subtotal</b></td>
						<td  style='border: 1px solid; width: 16.66%;'>
							$".$ro["subtotal"].
					       "</td>
				</tr>
				<tr>
					<td  style='border: 1px solid;'><b>IVA</b></td>
					<td  style='border: 1px solid;'>";
						$iva = $ro["subtotal"] * 0.16;
        $html .= "				$".$iva."
					</td>
				</tr>
				<tr>
					<td  style='border: 1px solid;'><b>Total</b></td>
					<td  style='border: 1px solid;'>
						$".($ro["subtotal"] + $iva)."
					</td>
				</tr>
			</table><br>
			<table style='border: 1px solid; border-collapse: collapse; width: 100%; text-align: center;'>
				<tr>
					<td style='height: 105px;'  valign='top'>
						<b>Observaciones:</b><br><br>".
						$ro["observaciones"]."
					</td>
				</tr>
			</table><br>
			<table style='border: 1px solid; border-collapse: collapse; width: 100%; text-align: center;'>
				<tr>
					<td style='height: 50px;'>
						Autoricé el trabajo antes mencionado con las condiciones especificadas y de acuerdo completamente a mis
						instrucciones. Realizado el trabajo a mi entera conformidad, me comprometo a pagar la cantidad establecida.
					</td>
				</tr>
			</table><br>
			<table style='border: 1px solid; border-collapse: collapse; width: 50%; text-align: center; position: absolute; left: 25%;'>
			<tr>
				<td style='height: 80px;'  valign='top'>
					<b>Recibí de conformidad</b>
				</td>
			</tr>
			<tr>
				<td style='border: 1px solid;'>
					<b>$fecha</b>
				</td>
			</tr>
		  </body>
		</html>
	";
	$dompdf->load_html($html);
	$dompdf->render();
	$dompdf->stream(
		"$folio.pdf",
		array(
			"Attachment" => false
		)
	);
?>
