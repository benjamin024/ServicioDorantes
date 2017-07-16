<?php
	include("menu.php");
	require("conexion.php");
	$folio =@$_GET["id"];
	$sql = "SELECT * FROM Cliente WHERE IDCliente = '$folio';";
	$info = $conn->query($sql);
?>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<center>
				<br><br><span style="font-size: 2.2em; font-weight: bold;">Información del cliente</span><br><br>
				<?php
					while($r = $info->fetch_assoc()){
						echo "<table class='col-md-7 col-md-offset-3'><tbody>";
						echo "<tr><td style='text-align: right;'><span style='font-size: 1.0em; font-weight: bold;'>Folio: </span></td><td>&nbsp;&nbsp;</td>";
						echo "<td><span style='font-size: 1.0em;'>".$r["IDCliente"]."</span></td></tr>";
						echo "<tr><td style='text-align: right;'><span style='font-size: 1.0em; font-weight: bold;'>Nombre: </span></td><td>&nbsp;&nbsp;</td>";
						$cliente = $r["nombre"];
						echo "<td><span style='font-size: 1.0em;'>".$cliente." ".$r["apellido"]."</span></td></tr>";
						echo "<tr><td style='text-align: right;'><span style='font-size: 1.0em; font-weight: bold;'>Teléfono: </span></td><td>&nbsp;&nbsp;</td>";
						echo "<td><span style='font-size: 1.0em;'>".$r["telefono"]."</span></td></tr>";
						echo "<tr><td style='text-align: right;'><span style='font-size: 1.0em; font-weight: bold;'>Correo Electrónico: </span></td><td>&nbsp;&nbsp;</td>";
						echo "<td><span style='font-size: 1.0em;'>".$r["email"]."</span></td></tr>";
						echo "</tbody></table>";
					}
					
					$sql = "SELECT * FROM Auto WHERE cliente = '$folio';";
					$autos = $conn->query($sql);
					if($autos->num_rows < 1){
						echo "<br><br><br><br><br><br><span style='font-size: 1.7em; font-weight: bold;'>No tiene automóviles registrados</span>";
					}else{
					?>
						<br><br><br><br><br><span style="font-size: 2.2em; font-weight: bold;">Automóviles</span><br><br>
						<span style='font-size: 1.2em;'>Da clic en las placas del auto para mayor información</span>
						<table class="table table-bordered table-responsive table-hover">
						<thead  style="text-align: center;" class="bg-primary">
							<tr>
								<th class="col-md-3">Placas</th>
								<th class="col-md-3">Marca</th>
								<th class="col-md-3">Submarca</th>
								<th class="col-md-3">Modelo</th>
							</tr>
						</thead>
						<tbody  style="text-align: center;">
					<?php
						while($r = $autos->fetch_assoc()){
							echo "<tr style='background-color: #FFFFFF;'><td><a href='auto.php?placas=".$r["placas"]."'>".$r["placas"]."</a></td>";
							echo "<td>".$r["marca"]."</td>";
							echo "<td>".$r["submarca"]."</td>";
							echo "<td>".$r["modelo"]."</td></tr>";
						}
						echo "</tbody></table>";
					}
				?>
					<br><br><a href="formAuto.php?cliente=<?php echo $folio;?>&nombre=<?php echo $cliente;?>">
						<button type="submit" class="btn btn-primary">Registrar nuevo auto</button>
					</a>
			</center>
		</div>
	</div>
</div>
