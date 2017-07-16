<?php
	include("menu.php");
	require("conexion.php");
	
	$folio =@$_GET["folio"];
	
	$sql = "SELECT * FROM Presupuesto WHERE folio='$folio';";
	$presupuesto = $conn->query($sql);
	if($presupuesto->num_rows < 1)
		echo "<center><br><br><span style='font-size: 2.2em; font-weight: bold;'>Folio de Presupuesto no válido</span><br><br><a href=presupuesto.php><button class='btn btn-primary ' type='submit'>Regresar</button></a></center>";
	else{
		$rp = $presupuesto->fetch_assoc();
	
?>
<script type="text/javascript">
	function envia(folio){
		console.log(folio);
		var mail = prompt("Ingresa el correo electrónico:", "");
		if (!(mail == null || mail == ""))
			window.open("imprimePresupuesto.php?folio="+folio+"&mail="+mail, "_blank");

	}
</script>
<div class="container">
	<div class="row">
		<br>
		<div class="col-md-8 col-md-offset-2">
		<center><span style='font-size: 2.2em; font-weight: bold;'>Consulta de Presupuesto</span><br>
		</div>
		<div class="col-md-12"><br></div>
		<div class="col-md-8 col-md-offset-2" style="border: solid black 2px; background-color: #FFFFFF;">
			<div class="col-md-12"><br></div>
			<div class="col-md-4">
				<img src="img/Logo.jpg" width="100%">
			</div>
			<div class="col-md-5" style="color:  #007ED2;">
				<br>
				<center><h2>Servicio Dorantes</h2></center>
			</div>
			<div clas="col-md-3"></div>
			<div class="col-md-12">	
			<hr style="height: 3px; background-color:  #007ED2;" />
			<?php
				setlocale(LC_TIME, 'es_MX.UTF-8');
				$fecha = strftime("Ciudad de México a %d de %B de %G",strtotime($rp["fecha"]));
				echo "<p style='text-align: right;'><b>$fecha</b></p>";
				echo "<br><center><span style='font-weight: bold; font-size: 2.0em;'>".$rp["titulo"]."</span></center><br>";
			?>
			</div>
			<div class="col-md-12">
				<table class="table-responsive" style="border: 1px solid; width: 100%; text-align: center;">
					<thead>
						<tr>
							<th class="col-md-6" style="border: 1px solid; text-align: center;">Descripción del trabajo</th>
							<th class="col-md-2" style="border: 1px solid; text-align: center;">Mano de Obra</th>
							<th class="col-md-2" style="border: 1px solid; text-align: center;">Refacciones</th>
							<th class="col-md-2" style="border: 1px solid; text-align: center;">Total</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql = "SELECT * FROM Trabajo WHERE ordenPresupuesto = '".$rp["folio"]."';";
						$trabajos = $conn->query($sql);
						while($r = $trabajos->fetch_assoc()){
							echo "<tr><td style='border: 1px solid;'>".$r["descripcion"]."</td>";
							if($r["manoObra"] == 0)
								$mano = "";
							else
								$mano = "$".$r["manoObra"];
							echo "<td style='border: 1px solid;'>$mano</td>";
							if($r["refacciones"] == 0)
								$ref = "";
							else
								$ref = "$".$r["refacciones"];
							echo "<td style='border: 1px solid;'>$ref</td>";
							echo "<td style='border: 1px solid;'>$".($r["manoObra"] + $r["refacciones"])."</td></tr>";
						}
						?>
					</tbody>
				</table>
				<table class="table-responsive" style="border: 1px solid; width: 100%; text-align: center;">
					<tr style="border-top: hidden;">
						<td  style="border: 1px solid;" rowspan=3 class="col-md-8" valign="top">
							<b>Notas</b><br>
							<?php echo $rp["notas"]; ?>
						</td>
						<td  style="border: 1px solid;" class="col-md-2"><b>Subtotal</b></td>
						<td  style="border: 1px solid;" class="col-md-2" id="subtotal">
							<?php echo "$".$rp["subtotal"]; ?>
						</td>
					</tr>
					<tr>
						<td  style="border: 1px solid;"><b>IVA</b></td>
						<td  style="border: 1px solid;" id="iva">
							<?php
								$iva = $rp["subtotal"] * 0.16;
								echo "$".$iva;
							?>
						</td>
					</tr>
					<tr>
						<td  style="border: 1px solid;"><b>Total</b></td>
						<td  style="border: 1px solid;" id="total">
							<?php echo "$".($rp["subtotal"] + $iva); ?>
						</td>
					</tr>
				</table><br>
			</div>
			<div class="col-md-12" style="color:  #007ED2; text-align: center;">	
			<hr style="height: 3px; background-color:  #007ED2;" />
			<?php
				$sql = "SELECT * FROM Usuario WHERE user = '$usr';";
				$admin = $conn->query($sql);
				$r = $admin->fetch_assoc();
				echo $r["direccion"]."<br>Teléfono: ".$r["telefono"]."&nbsp;&nbsp;&nbsp;Celular: ".$r["celular"]."&nbsp;&nbsp;&nbsp;Email: ".$r["email"]."<br>";
			?>
			</div>
			<div class="col-md-12"><br></div>
		</div>
		<div class="col-md-8 col-md-offset-2"><center>
			<br><br>
			<a href="imprimePresupuesto.php?folio=<?php echo $folio;?>" target="_blank" style="color: #222;"><span style="font-size: 1.5em;" class="glyphicon glyphicon-print" aria-hidden="true""></span></a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<span style="cursor: pointer; font-size: 1.5em; color: #222; cursor: pointer;" class="glyphicon glyphicon-envelope" aria-hidden="true" onclick="envia('<?php echo $folio; ?>');"></span>
			<br><br><a href="presupuestos.php"><button class="btn btn-primary " type="submit">Regresar a Presupuestos</button></a>
		</center></div>
	</div>
</div>
<?php } ?>
