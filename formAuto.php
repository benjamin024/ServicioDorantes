<?php
	include("menu.php");
	$cliente =@$_GET["cliente"];
	$nombre =@$_GET["nombre"];
?>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2"><center>
			<br><br>
			<span style="font-size: 3.0em; font-weight: bold;">Registrar nuevo auto de <?php echo $nombre; ?></span><br><br>
			<span style="font-size: 1.7em; font-weight: bold;">Ingresa la información del auto:</span><br><br>
			<div class="col-md-6 col-md-offset-3">
			<form class="form" method="post" action="registraAuto.php">
				  <div class="form-group">
				  <label class="control-label" for="placas">Placas:</label>
				  <input class="form-control" id="placas" name="placas" placeholder="Placas" required/>
				  </div>
				  <div class="form-group">
				  <label class="control-label" for="marca">Marca:</label>
				  <input class="form-control" id="marca" name="marca" placeholder="Marca"/>
				  </div>
				  <div class="form-group">
				  <label class="control-label" for="submarca">Submarca:</label>
				  <input class="form-control" id="submarca" name="submarca" placeholder="Submarca" required/>
				  </div>
				  <div class="form-group">
				  <label class="control-label" for="email">Modelo:</label>
				  <input type="number" class="form-control" id="modelo" name="modelo" placeholder="Modelo" >
				  </div>
				  <input type="hidden" name="cliente" value="<?php echo $cliente;?>"/>
				<br><br><button class="btn btn-primary " type="submit">Registrar auto</button>
			</form>
			</div>
		</center></div>
	</div>
</div>
