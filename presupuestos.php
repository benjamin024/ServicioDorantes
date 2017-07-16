<?php
	include("menu.php");
	require("conexion.php");
	$f =@$_POST["fecha"];
	if(empty($f))
		$f = date("Y-m");
	$sql = "SELECT folio, fecha, titulo FROM Presupuesto WHERE fecha LIKE '$f%' ORDER BY fecha DESC;";
	$consulta = $conn->query($sql);
?>
<html>
	<head>
		 <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    		<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">	
	</head>
	<body>
		<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2"><center>
            <br><br>
            <span style='font-size: 2.2em; font-weight: bold;'>Presupuestos</span>
            <form action="ordenes.php" method="post"><br>
		    <div class="form-group">
		        <div class="input-group date form_date col-md-5" data-date="" data-date-format="MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm">
		            <?php
		            	$mesA = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				$mes = $mesA[date("n")-1];
				$anio = date("Y");
		            ?>
		            <input class="form-control" size="16" type="text" value="<?php 
		            if(!empty($f)){
		            	$aux = substr($f,5);
		            	$anio = substr($f,0,4);
		            	$mes = $mesA[$aux-1];
		            }
		            echo $mes." ".$anio; 
		            ?>" readonly>
			    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		        </div>
			<input type="hidden" id="dtp_input2" name="fecha" value="" /><br/>
			<button class="btn btn-primary " type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
		    </div>
            </form><br>
            <?php
            	if($consulta->num_rows < 1)
            		echo "<span style='font-size: 1.7em; font-weight: bold;'>No hay registro de presupuestos en este mes</span><br>";
            	else{
            ?>
            		<span style='font-size: 1.2em;'>Da clic en el folio para consultar el Presupuesto completo</span>
            		<table class="table table-bordered table-responsive table-hover">
			<thead  style="text-align: center;" class="bg-primary">
				<tr>
					<th class="col-md-3">Folio</th>
					<th class="col-md-3">Fecha</th>
					<th class="col-md-3">Título</th>
				</tr>
			</thead>
			<tbody  style="text-align: center;">
	     <?php
	     		while($r = $consulta->fetch_assoc()){
	     			echo "<tr style='background-color: #FFFFFF;'><td><a href='presupuesto.php?folio=".$r["folio"]."'>".$r["folio"]."</a></td>";
				setlocale(LC_TIME, 'es_MX.UTF-8');
				$fecha = strftime("%d de %B de %G",strtotime($r["fecha"]));
				echo "<td>".$fecha."</td>";
				echo "<td>".$r["titulo"]."</td>";
	     		}
	     		echo "</tbody></table>";
		}
	     ?>
	     <br>
	     <a href='formPresupuesto.php'><button type='submit' class='btn btn-primary'>Nuevo Presupuesto</button></a>
        </center></div>
    </div>
</div>
	<script type="text/javascript" src="js/jquery-1.8.3.min.js" charset="UTF-8"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
	<script type="text/javascript">
		$('.form_date').datetimepicker({
			language:  'es',
			weekStart: 1,
        		todayBtn:  1,
			autoclose: 1,
			startView: 3,
			minView: 3,
			forceParse: 0
	    	});
	</script>
	</body>
</html>
