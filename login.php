<?php
	session_start();
	require('conexion.php');
	$user=@$_POST['user'];
	$pass=@$_POST['pass'];
	
	$sql = "SELECT * FROM Usuario WHERE user='$user' and pass='$pass';";
	

	$consultaUser = $conn->query($sql);
	if($consultaUser->num_rows > 0){ //Usuario Correcto
		while($resultado = $consultaUser->fetch_assoc()) {
			$_SESSION['usuario'] = $resultado["user"];
			$_SESSION['nombre'] = $resultado["nombre"];
		}
		header('Location: indexAdmin.php');
			
	}else{
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8_spanish_ci' />";
		echo "<div class=container><div class=row><div class='col-md-8 col-md-offset-2'>";
		echo "<center><span style='font-size: 3.0em; font-weight: bold;'>Usuario y/o Contraseña Incorrectos</span><br>";
		echo "<span style='font-size: 1.5em; font-weight: bold;'>Revisa tu usuario y contraseña e inténtalo nuevamente <br> ¿Aún no tienes cuenta? <a href='formUsuario.php?tipo=1'>Regístrate</a></span></center>";
		echo "</div></div></div>";	
	}
	
	
?>
