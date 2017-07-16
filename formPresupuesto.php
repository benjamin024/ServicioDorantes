<?php
	include("menu.php");
	require("conexion.php");
?>
<div class="container">
	<div class="row">
		<br>
		<div class="col-md-8 col-md-offset-2">
		<center><span style='font-size: 2.2em; font-weight: bold;'>Nuevo Presupuesto</span><br>
		<b>Completa la información del Presupuesto.</b></center>
		</div>
		<div class="col-md-12"><br></div>
		<form action="registraPresupuesto.php" method="post">
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
				$mesA = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				$dia = date("d");
				$mes = $mesA[date("n")-1];
				$mesN = date("m");
				$anio = date("Y");
				echo "<p style='text-align: right;'><b>Ciudad de México a $dia de $mes de $anio</b></p>";
			?>
			<input type="text" name="titulo" class="form-control" placeholder="Título del Presupuesto" style="text-align: center; font-weight: bold; font-size: 2.0em;" required/><br>
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
				<thead> <tr><th>Notas:</th></thead>
				<tbody>
				<td><textarea class="form-control" name="notas" style="resize: none;" rows="3"></textarea></td>
				</tbody>
				</table>
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
		<input type="hidden" name="numTrabajos" id="fT" value="1"/>
		<input type="hidden" name="subtotal" id="fSub" value="0"/>
		<input type="hidden" name="fecha" value="<?php echo "$anio-$mesN-$dia"; ?>" />
		<div class="col-md-8 col-md-offset-2"><br><center><button class="btn btn-primary " type="submit">Registrar Presupuesto</button></center></div>
		</form>
	</div>
</div>
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
