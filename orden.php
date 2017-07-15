<?php
	include("menu.php");
	require("conexion.php");
	
	$folio =@$_GET["folio"];
	
	$sql = "SELECT * FROM Orden WHERE folio='$folio';";
	$orden = $conn->query($sql);
	if($orden->num_rows < 1)
		echo "<center><br><br><span style='font-size: 2.2em; font-weight: bold;'>Folio de Orden de Servicio no válido</span><br><br><a href=ordenes.php><button class='btn btn-primary ' type='submit'>Regresar</button></a></center>";
	else{
		$ro = $orden->fetch_assoc();
		$sql = "SELECT a.placas, a.marca, a.submarca, a.modelo, a.cliente, c.nombre, c.apellido, c.telefono, c.email FROM Auto as a, Cliente as c WHERE a.cliente = c.IDCliente AND a.placas = '".$ro["auto"]."';";
		$data = $conn->query($sql);
		$d = $data->fetch_assoc();
		$sql = "SELECT * FROM Usuario WHERE user = '$usr';";
		$admin = $conn->query($sql);
		$r = $admin->fetch_assoc();
		?>
		<div class="container">
			<div class="row">
				<br>
				<div class="col-md-8 col-md-offset-2">
					<center><span style='font-size: 2.2em; font-weight: bold;'>Consulta de Orden de Servicio</span></center>
				</div>
				<div class="col-md-12"><br></div>
				<div class="col-md-8 col-md-offset-2" style="border: solid black 2px; color: #007ED2;">
					<div class="col-md-12"><br></div>
					<div class="col-md-4">
						<img src="img/Logo.jpg" width="100%">
					</div>
					<div class="col-md-4">
						<br>
						<center><h3>Servicio Dorantes</h3></center>
					</div>
					<div class="col-md-4" style="font-size: 10px;">
						<center>
						<b>Orden de servicio</b><br>
						<?php
						echo $r["nombre"] . "<br>";
						echo "RFC: DOPB670906259<br>";
						echo $r["direccion"] . "<br>";
						echo "Teléfono: " . $r["telefono"] . "<br>";
						echo "Celular: " . $r["celular"] . "<br>";
						echo "Email: " . $r["email"] . "<br>";
						?>
						</center>
					</div>
					<div class="col-md-12">
						<br>
						<b>Nombre:</b><u> <?php echo $d["nombre"] . " " .$d["apellido"]; ?> </u> <br>
						<b>Teléfono: </b><u> <?php echo $d["telefono"]; ?> </u> <br>
						<b>Correo Electrónico: </b><u> <?php echo $d["email"]; ?> </u> <br>
						<br>
					</div>
					<div class="col-md-12">
						<table class="table-responsive" style="border: 1px solid; width: 100%; text-align: center;">
							<thead>
								<tr>
									<th style="border: 1px solid; text-align: center;">Marca</th>
									<th style="border: 1px solid; text-align: center;">Submarca</th>
									<th style="border: 1px solid; text-align: center;">Modelo / año</th>
									<th style="border: 1px solid; text-align: center;">Placas</th>
									<th style="border: 1px solid; text-align: center;">Kilometraje</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php
									echo "<td style='border: 1px solid; border-top: hidden;'>".$d["marca"]."</td>";
									echo "<td style='border: 1px solid; border-top: hidden;'>".$d["submarca"]."</td>";
									echo "<td style='border: 1px solid; border-top: hidden;'>".$d["modelo"]."</td>";
									echo "<td style='border: 1px solid; border-top: hidden;'>".$d["placas"]."</td>";
									echo "<td style='border: 1px solid; border-top: hidden;'>".$ro["kilometraje"]." Km</td>";
									?>
								</tr>
							</tbody>
						</table><br>
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
								$sql = "SELECT * FROM Trabajo WHERE ordenPresupuesto = '".$ro["folio"]."';";
								$trabajos = $conn->query($sql);
								while($r = $trabajos->fetch_assoc()){
									echo "<tr><td style='border: 1px solid;'>".$r["descripcion"]."</td>";
									echo "<td style='border: 1px solid;'>$".$r["manoObra"]."</td>";
									echo "<td style='border: 1px solid;'>$".$r["refacciones"]."</td>";
									echo "<td style='border: 1px solid;'>$".($r["manoObra"] + $r["refacciones"])."</td></tr>";
								}
							?>
							</tbody>
						</table>
						<table class="table-responsive" style="border: 1px solid; width: 100%; text-align: center;">
							<tr style="border-top: hidden;">
								<td  style="border: 1px solid;" rowspan=3 class="col-md-8; text-align: left;">
									<b>Observaciones</b><br>
									<?php echo $ro["observaciones"]; ?>
								</td>
								<td  style="border: 1px solid;" class="col-md-2"><b>Subtotal</b></td>
								<td  style="border: 1px solid;" class="col-md-2" id="subtotal">
								<?php echo "$".$ro["subtotal"]; ?>
								</td>
							</tr>
							<tr>
								<td  style="border: 1px solid;"><b>IVA</b></td>
								<td  style="border: 1px solid;" id="iva">
								<?php
									$iva = $ro["subtotal"] * 0.16;
									echo "$".$iva;
								?>
								</td>
							</tr>
							<tr>
								<td  style="border: 1px solid;"><b>Total</b></td>
								<td  style="border: 1px solid;" id="total">
								<?php echo "$".($ro["subtotal"] + $iva); ?>
								</td>
							</tr>
						</table>
					</div>
					<?php
						setlocale(LC_TIME, 'es_MX.UTF-8');
						$fecha = strftime("Ciudad de México a %d de %B de %G",strtotime($ro["fecha"]));
						echo "<div class='col-md-12'><br><center><b>$fecha</b></center></div>";
					?>
					<div class="col-md-12"><br></div>
				</div>
				<div class="col-md-8 col-md-offset-2"><center>
					<br><br>
					<a href="imprimeOrden.php?folio=<?php echo $folio;?>" target="_blank" style="color: black;"><span style="font-size: 1.5em;" class="glyphicon glyphicon-print" aria-hidden="true""></span></a>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<span style="cursor: pointer; font-size: 1.5em;" class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
					<br><br><a href="auto.php?placas=<?php echo $ro["auto"]; ?>"><button class="btn btn-primary " type="submit">Ver información del auto</button></a>
				</center></div>
<?php
	}
?>
