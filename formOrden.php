<?php
	include("menu.php");
	require("conexion.php");
	$auto =@$_GET["auto"];
	if(!empty($auto)){
		$auto = str_replace("-","",$auto);
		$auto = str_replace(" ","",$auto);
		$auto = strtoupper($auto);
		$sql = "SELECT a.placas, a.marca, a.submarca, a.modelo, a.cliente, c.nombre, c.apellido, c.telefono, c.email FROM Auto as a, Cliente as c WHERE a.cliente = c.IDCliente AND a.placas = '$auto';";
		$data = $conn->query($sql);
		if($data->num_rows < 1)
			echo "<center><br><br><span style='font-size: 2.2em; font-weight: bold;'>No se encontraron coincidencias. Revisa las placas e inténtalo nuevamente</span><br><br><a href=formOrden.php><button class='btn btn-primary ' type='submit'>Regresar</button></a></center>";
		else{
			$d = $data->fetch_assoc();
			$sql = "SELECT * FROM Usuario WHERE user = '$usr';";
			$admin = $conn->query($sql);
			$r = $admin->fetch_assoc();
			?>
			<div class="container">
				<div class="row">
					<br>
					<form action="registraOrden.php" method="post">
					<div class="col-md-8 col-md-offset-2">
					<center><span style='font-size: 2.2em; font-weight: bold;'>Nueva Orden de Servicio</span><br>
					<b>Completa la información de la orden de servicio.</b></center>
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
										?>
										<td style='border: 1px solid; border-top: hidden;'><input type="number" name="kilometraje" class="form-control"/></td>
									</tr>
								</tbody>
							</table><br>
						</div>
						<div class="col-md-12">
							<table  id="trabajosTable" class="table-responsive" style="border: 1px solid; width: 100%; text-align: center;">
								<thead>
									<tr>
										<th class="col-md-6" style="border: 1px solid; text-align: center;">Descripción del trabajo</th>
										<th class="col-md-2" style="border: 1px solid; text-align: center;">Mano de Obra</th>
										<th class="col-md-2" style="border: 1px solid; text-align: center;">Refacciones</th>
										<th class="col-md-2" style="border: 1px solid; text-align: center;">Total</th>
									</tr>
								</thead>
								<tbody id="trabajosBody">
									<tr id="w1">
									<td style="border: 1px solid;"><input type="text" id="t1" name="t1" required class="form-control"/></td>
									<td style="border: 1px solid;"><input type="number" id="mo1" name="mo1" class="form-control" onblur="getTotal(1);"/></td>
									<td style="border: 1px solid;"><input type="number" id="r1" name="r1" class="form-control" onblur="getTotal(1);"/></td>
									<td style="border: 1px solid;" id="tot1"></td></tr>
								</tbody>
							</table>
							<table class="table-responsive" style="border: 1px solid; width: 100%; text-align: center;">
								<tr style="border-top: hidden;">
									<td  style="border: 1px solid;" rowspan=3 class="col-md-8">
										<span id="mas" style="cursor: pointer; font-size: 1.5em; color: green;" class="glyphicon glyphicon-plus" aria-hidden="true" onclick="agregar();"></span>
										&nbsp;&nbsp;
										<span id="menos" style="cursor: pointer; font-size: 1.5em; color: red; visibility: hidden;" class="glyphicon glyphicon-minus" aria-hidden="true" onclick="quitar();"></span>
									</td>
									<td  style="border: 1px solid;" class="col-md-2"><b>Subtotal</b></td>
									<td  style="border: 1px solid;" class="col-md-2" id="subtotal"></td>
								</tr>
								<tr>
									<td  style="border: 1px solid;"><b>IVA</b></td>
									<td  style="border: 1px solid;" id="iva"></td>
								</tr>
								<tr>
									<td  style="border: 1px solid;"><b>Total</b></td>
									<td  style="border: 1px solid;" id="total"></td>
								</tr>
							</table>
						</div>
						<div class="col-md-12">
							<br>
							<table  class="table-responsive" style="border: 1px solid; width: 100%;">
							<thead> <tr><th>Observaciones:</th></thead>
							<tbody>
							<td><textarea class="form-control" name="observaciones" style="resize: none;" rows="3"></textarea></td>
							</tbody>
							</table>
						</div>
						<?php
							$mesA = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
							$dia = date("d");
							$mes = $mesA[date("n")-1];
							$anio = date("Y");
						?>
						<div class="col-md-12"><center>
							<div class="form-group">
							<br><b>Ciudad de México a </b>
							<div class="input-group date form_date col-md-6" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
							    <?php
							    	$mesA = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
								$mes = $mesA[date("n")-1];
								$anio = date("Y");
								$dia = date("d");
							    ?>
							    <input class="form-control" size="100%" type="text" value="<?php echo "$dia $mes $anio";?>" readonly>
							    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							<input type="hidden" id="dtp_input2" name="fecha" value="" /><br/>
						</center></div>
					</div>
					<input type="hidden" name="numTrabajos" id="fT" value="1"/>
					<input type="hidden" name="placas" value="<?php echo $auto; ?>" />
					<input type="hidden" name="subtotal" id="fSub" value="0"/>
					<div class="col-md-8 col-md-offset-2"><br><center><button class="btn btn-primary " type="submit">Registrar Orden de Servicio</button></center></div>
					</form>
				</div>
			</div>
			<?php
		}
	}else{
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2"><center>
					<br><br><span style='font-size: 2.2em; font-weight: bold;'>Ingresa las placas del auto:</span>
					<div class="col-md-6 col-md-offset-3"><br>
					<form class="form" method="get" action="formOrden.php">
					  <div class="form-group">
					  <input class="form-control" id="placas" name="auto" placeholder="Placas" required/>
					  </div>
					  <button class="btn btn-primary " type="submit">Buscar auto</button>
					</form>
					</div>
				</center></div>
			</div>
		</div>
		<?php
	}
?>

<script type="text/javascript">
	var t = 1;
	var limite = 10;
	function agregar(){
		 var tArray = [];
		 var mArray = [];
		 var rArray = [];
		 var totArray = [];
		 for(var i = 1; i <= t; i++){
		 	tArray[i] = document.getElementById("t"+i).value;
		 	mArray[i] = document.getElementById("mo"+i).value;
		 	rArray[i] = document.getElementById("r"+i).value;
		 	totArray[i] = document.getElementById("tot"+i).value;
		 }
		 t++;
		 document.getElementById("fT").value = t;
		 if(t > 1)
		 	document.getElementById("menos").style.visibility = "visible";
		 if(t == limite)
		 	document.getElementById("mas").style.visibility = "hidden";
		 var fila;
		 fila  = "<tr id='w"+t+"'>";
		 fila += "<td style='border: 1px solid;'><input type='text' id='t"+t+"' name='t"+t+"' required class='form-control'/></td>";
		 fila += "<td style='border: 1px solid;'><input type='number' id='mo"+t+"' name='mo"+t+"' class='form-control' onblur='getTotal("+t+");'/></td>";
		 fila += "<td style='border: 1px solid;'><input type='number' id='r"+t+"' name='r"+t+"' class='form-control'  onblur='getTotal("+t+");'/></td>";
		 fila += "<td style='border: 1px solid;' id='tot"+t+"'></td></tr>";
		 document.getElementById("trabajosTable").tBodies.namedItem("trabajosBody").innerHTML += fila;
		 for(var i = 1; i < t; i++){
		 	document.getElementById("t"+i).value = tArray[i];
		 	document.getElementById("mo"+i).value = mArray[i];
		 	document.getElementById("r"+i).value = rArray[i];
		 	document.getElementById("tot"+i).value = totArray[i];
		 }
	}
	
	function quitar(){
		var fila = document.getElementById("w"+t);
		fila.parentNode.removeChild(fila);
		t--;
		if(t == 1)
			document.getElementById("menos").style.visibility = "hidden";
		if(t < limite)
			document.getElementById("mas").style.visibility = "visible";
		document.getElementById("fT").value = t;
	}
	function getTotal(num){
		var mano = document.getElementById("mo"+num).value;
		var ref = document.getElementById("r"+num).value;
		if(mano === "")
			mano = 0;
		if(ref === "")
			ref = 0;
		var tot = parseInt(mano) + parseInt(ref);
		if(tot === 0)
			tot = "";
		else
			tot = "$"+tot;
		document.getElementById("tot"+num).innerHTML = tot;
		var subtotal = 0;
		var iva = 0;
		var total = 0;
		for(var i = 1; i <= t; i++){
			var valor = document.getElementById("tot"+i).innerHTML;
			if(valor != ""){
				var sub = parseInt(valor.substring(1));
				console.log(sub);
				subtotal += sub;
			}
		}
		iva = subtotal * 0.16;
		total = subtotal + iva;
		document.getElementById("fSub").value = subtotal;
		if(subtotal === 0)
			subtotal = "";
		else
			subtotal = "$"+subtotal;
		if(iva === 0)
			iva = "";
		else
			iva = "$"+iva.toFixed(2);
		if(total === 0)
			total = "";
		else
			total = "$"+total.toFixed(2);
		document.getElementById("subtotal").innerHTML = subtotal;
		document.getElementById("iva").innerHTML = iva;
		document.getElementById("total").innerHTML = total;
	}
</script>
<script type="text/javascript" src="js/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
<script type="text/javascript">
	var f = new Date();
	console.log(f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear());
	$('.form_date').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0,
		initialDate: f
    });
</script>

