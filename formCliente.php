<?php
	include("menu.php");
?>

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2"><center>
			<br><br>
			<span style="font-size: 3.0em; font-weight: bold;">Registrar nuevo cliente</span><br><br>
			<span style="font-size: 1.7em; font-weight: bold;">Ingresa la información del cliente:</span><br><br>
			<form class="form" method="post" action="registraCliente.php">
				<div class="col-md-6">
				  <div class="form-group">
				  <label class="control-label" for="nombre">Nombre(s):</label>
				  <input class="form-control" id="nombre" name="nombre" placeholder="Nombre(s)" required/>
				  </div>
				</div>
				<div class="col-md-6">
				  <div class="form-group">
				  <label class="control-label" for="apellidos">Apellidos:</label>
				  <input class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" required/>
				  </div>
				</div>
				<div class="col-md-6">
				  <div class="form-group">
				  <label class="control-label" for="telefono">Teléfono:</label>
				  <input class="form-control" id="telefono" name="telefono" placeholder="Teléfono" />
				  </div>
				</div>
				<div class="col-md-6">
				  <div class="form-group">
				  <label class="control-label" for="email">Correo Electrónico:</label>
				  <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" >
				  </div>
				</div>
				<br><br><button class="btn btn-primary " type="submit">Registrar cliente</button>
			</form>
		</center></div>
	</div>
</div>
