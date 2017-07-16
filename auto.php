<?php
	include("menu.php");
	require("conexion.php");
	
	$placas =@$_GET["placas"];
	
	$placas = str_replace("-","",$placas);
	$placas = str_replace(" ","",$placas);
	$placas = strtoupper($placas);
	
	$sql = "SELECT a.placas, a.marca, a.submarca, a.modelo, a.cliente, c.nombre, c.apellido FROM Auto as a, Cliente as c WHERE a.cliente = c.IDCliente AND a.placas = '$placas';";
	$consulta = $conn->query($sql);
?>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2"><center>
		<?php
			if($consulta->num_rows < 1){
				echo "<br><br><span style='font-size: 2.2em; font-weight: bold;'>No se encontraron coincidencias. Revisa las placas e inténtalo nuevamente</span>";
			}else{
				echo "<br><br><span style='font-size: 2.2em; font-weight: bold;'>Información del auto</span>";
				while($r = $consulta->fetch_assoc()){
					echo "<table class='col-md-7 col-md-offset-3'><tbody>";
					echo "<tr><td style='text-align: right;'><span style='font-size: 1.0em; font-weight: bold;'>Placas: </span></td><td>&nbsp;&nbsp;</td>";
					echo "<td><span style='font-size: 1.0em;'>".$r["placas"]."</span></td></tr>";
					echo "<tr><td style='text-align: right;'><span style='font-size: 1.0em; font-weight: bold;'>Marca: </span></td><td>&nbsp;&nbsp;</td>";
					echo "<td><span style='font-size: 1.0em;'>".$r["marca"]."</span></td></tr>";
					echo "<tr><td style='text-align: right;'><span style='font-size: 1.0em; font-weight: bold;'>Submarca: </span></td><td>&nbsp;&nbsp;</td>";
					echo "<td><span style='font-size: 1.0em;'>".$r["submarca"]."</span></td></tr>";
					echo "<tr><td style='text-align: right;'><span style='font-size: 1.0em; font-weight: bold;'>Modelo: </span></td><td>&nbsp;&nbsp;</td>";
					echo "<td><span style='font-size: 1.0em;'>".$r["modelo"]."</span></td></tr>";
					echo "<tr><td style='text-align: right;'><span style='font-size: 1.0em; font-weight: bold;'>Dueño: </span></td><td>&nbsp;&nbsp;</td>";
					echo "<td><a href='cliente.php?id=".$r["cliente"]."'><span style='font-size: 1.0em;'>".$r["nombre"]." ".$r["apellido"]."</span></a></td></tr>";
					echo "</tbody></table><br><br>";
					$cliente = $r["cliente"];
				}
				
				$sql = "SELECT * FROM Orden WHERE auto = '$placas';";
				$historial = $conn->query($sql);
				if($historial->num_rows < 1){
						echo "<br><br><br><br><br><br><span style='font-size: 1.7em; font-weight: bold;'>Este auto no tiene historial</span>";
				}else{ ?>
					<br><br><br><br><br><br><span style='font-size: 2.2em; font-weight: bold;'>Historial</span>
					<br><span style='font-size: 1.2em;'>Da clic en el folio para consultar la orden de servicio completa</span>
						<table class="table table-bordered table-responsive table-hover">
						<thead  style="text-align: center;" class="bg-primary">
							<tr>
								<th class="col-md-3">Folio</th>
								<th class="col-md-3">Fecha</th>
								<th class="col-md-3">Observaciones</th>
							</tr>
						</thead>
						<tbody  style="text-align: center;">
					<?php
						while($r = $historial->fetch_assoc()){
							echo "<tr style='background-color: #FFFFFF;'><td><a href='orden.php?folio=".$r["folio"]."'>".$r["folio"]."</a></td>";
							setlocale(LC_TIME, 'es_MX.UTF-8');
							$fecha = strftime("%d de %B de %G",strtotime($r["fecha"]));
							echo "<td>".$fecha."</td>";
							echo "<td>".$r["observaciones"]."</td></tr>";
						}
						echo "</tbody></table>";
					
				}
				echo "<br><a href='formOrden.php?auto=$placas'><button type='submit' class='btn btn-primary'>Nueva Orden de Servicio</button></a>";
			}
		?>
		</center></div>
	</div>
</div>
