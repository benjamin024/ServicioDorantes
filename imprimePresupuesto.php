<?php
	require("conexion.php");
	$folio =@$_GET["folio"];
	$m =@ $_GET["mail"];
	$sql = "SELECT * FROM Presupuesto WHERE folio='$folio';";
	$presupuesto = $conn->query($sql);
	$rp = $presupuesto->fetch_assoc();
	setlocale(LC_TIME, 'es_MX.UTF-8');
	$fecha = strftime("Ciudad de México a %d de %B de %G",strtotime($rp["fecha"]));
	use Dompdf\Dompdf;
	require_once("dompdf/autoload.inc.php");
	$dompdf = new DOMPDF();
	$html = "
		<html>
		  <head><title>Presupuesto</title></head>
		  <body>
		    <table style='width: 100%;'>
		    	<tr>
		    		<td style='width: 35%;'><img src='img/Logo.jpg' width='200px'></td>
		    		<td style='width: 65%; color: #007ED2;'><h2>SERVICIO DORANTES</h2></td>
		    	</tr>
		    </table><br>
		    <hr style='height: 3px; background-color: #007ED2; border: 0px;'/>
		    <p style='text-align: right;'><b>$fecha</b></p>
		    <br><center><span style='font-weight: bold; font-size: 2.0em;'>".$rp["titulo"]."</span></center><br>
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
				$sql = "SELECT * FROM Trabajo WHERE ordenPresupuesto = '".$rp["folio"]."';";
				$trabajos = $conn->query($sql);
				while($r = $trabajos->fetch_assoc()){
					$html .= "<tr><td style='border: 1px solid;'>".$r["descripcion"]."</td>";
					if($r["manoObra"] == 0)
						$mano = "";
					else
						$mano = "$".$r["manoObra"];
					$html .= "<td style='border: 1px solid;'>$mano</td>";
					if($r["refacciones"] == 0)
						$ref = "";
					else
						$ref = "$".$r["refacciones"];
					$html .= "<td style='border: 1px solid;'>$ref</td>";
					$html .= "<td style='border: 1px solid;'>$".($r["manoObra"] + $r["refacciones"])."</td></tr>";
				}
	$html .= "		</tbody>
		        </table>
		        <table style='border: 1px solid; border-collapse: collapse; width: 100%; text-align: center;'>
		        	<tr style='border-top: hidden;'>
						<td  style='border: 1px solid; width: 66.66%;' rowspan=3' valign='top'>
							<b>Notas</b><br>"
							.$rp["notas"].
					       "</td>
						<td  style='border: 1px solid; width: 16.66%;'><b>Subtotal</b></td>
						<td  style='border: 1px solid; width: 16.66%;'>
							$".$rp["subtotal"].
					       "</td>
				</tr>
				<tr>
					<td  style='border: 1px solid;'><b>IVA</b></td>
					<td  style='border: 1px solid;'>";
						$iva = $rp["subtotal"] * 0.16;
        $html .= "				$".$iva."
					</td>
				</tr>
				<tr>
					<td  style='border: 1px solid;'><b>Total</b></td>
					<td  style='border: 1px solid;'>
						$".($rp["subtotal"] + $iva)."
					</td>
				</tr>
			</table>
		        <div style='position: absolute; bottom: 0%; color:  #007ED2; text-align: center; width: 100%;'>
		        	<hr style='height: 3px; background-color: #007ED2; border: 0px;'/>
		        	Lago Musters No. 74 Col. Argentina Antigua, Miguel Hidalgo, Ciudad de México. C.P.: 11270<br>
		        	Teléfono: 55277025&nbsp;&nbsp;&nbsp;Celular: 5523380682&nbsp;&nbsp;&nbsp;Email: servicio_dorantes@hotmail.com<br>
		        </div>
		  </body>
		</html>
	";
	
	$dompdf->load_html($html);
	$dompdf->render();
	if(empty($m)){
		$dompdf->stream(
			"$folio.pdf",
			array(
				"Attachment" => false
			)
		);
	}else{
		$pdf = $dompdf->output(); 
		//se guarda en un directorio temporal
		$nombre_archivo = "temp/$folio.pdf";
		file_put_contents($nombre_archivo, $pdf);
		header("Location: enviaPresupuesto.php?folio=$folio&mail=$m");
	}
?>
