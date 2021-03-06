<?php
	include("menu.php");
	require("conexion.php");
	$search =@$_POST["search"];
	if(empty($search))
		$sql = "SELECT * FROM Cliente ORDER BY apellido;";
	else
		$sql = "SELECT * FROM Cliente WHERE nombre LIKE '%$search%' OR apellido LIKE '%$search%' ORDER BY apellido;";
	$consulta = $conn->query($sql);
?>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<br><br>
			<center>
				<span style="font-size: 3.0em; font-weight: bold;">Clientes</span>
				<form action="clientes.php" method="post" class="form-inline">
				<div class="col-md-11">
				    <input type="text" size="80	%" class="form-control" id="search" name="search" placeholder="Busca por nombre o apellidos" value="<?php echo $search; ?>" />
				    </div>
				    <div class="col-md-1">
				  <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
				  </div>
				</form><br><br>
				<?php
					if($consulta->num_rows < 1){
						echo "<br><span style='font-size: 1.7em; font-weight: bold;'>No se encontraron coincidencias</span><br>";
					}else{
				?>
				<br><br>
					<span style='font-size: 1.2em;'>Da clic en el nombre del cliente para ver su información</span>
					<table class="table table-bordered table-responsive table-hover">
					<thead  style="text-align: center;" class="bg-primary">
						<tr>
							<th class="col-md-4">Nombre</th>
							<th class="col-md-4">Teléfono</th>
							<th class="col-md-2">Correo Electrónico</th>
						</tr>
					</thead>
					<tbody  style="text-align: center;">
					<?php
							while($resultado = $consulta->fetch_assoc()) {
								echo "";
								echo "<tr style='background-color: #FFFFFF;'><td><a href='cliente.php?id=".$resultado["IDCliente"]."'>".$resultado["nombre"]." ".$resultado["apellido"]."</a></td>";
								echo "<td>".$resultado["telefono"]."</td>";
								echo "<td>".$resultado["email"]."</td></tr>";
							}
				       	?>
				       	</tbody>
				</table>
				<?php   } ?>
				<br><a href="formCliente.php"><button type="submit" class="btn btn-primary">Registrar nuevo cliente</button></a>
			</center>
		</div>
	</div>
</div>
