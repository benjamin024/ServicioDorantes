<?php 
	session_start(); 
	$usr = $_SESSION['usuario'];
	if(empty($usr))
		header("location: index.html");
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/> 
    <title>Servicio Dorantes</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <style type="text/css">
	body{
	    background:url('Imagenes/background.jpg');
    	    background-attachment: fixed;
            padding:50px;
	}

	#login-dp{
	    min-width: 250px;
	    padding: 14px 14px 0;
	    overflow:hidden;
	    background-color:rgba(255,255,255,.8);
	}
	#login-dp .help-block{
	    font-size:12px    
	}
	#login-dp .bottom{
	    background-color:rgba(255,255,255,.8);
	    border-top:1px solid #ddd;
	    clear:both;
	    padding:14px;
	}
	#login-dp .social-buttons{
	    margin:12px 0    
	}
	#login-dp .social-buttons a{
	    width: 49%;
	}
	#login-dp .form-group {
	    margin-bottom: 10px;
	}
	.btn-fb{
	    color: #fff;
	    background-color:#3b5998;
	}
	.btn-fb:hover{
	    color: #fff;
	    background-color:#496ebc 
	}
	.btn-tw{
	    color: #fff;
	    background-color:#55acee;
	}
	.btn-tw:hover{
	    color: #fff;
	    background-color:#59b5fa;
	}
	@media(max-width:768px){
	    #login-dp{
		background-color: inherit;
		color: #fff;
	    }
	    #login-dp .bottom{
		background-color: inherit;
		border-top:0 none;
	    }
	}
    </style>
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        window.alert = function(){};
        var defaultCSS = document.getElementById('bootstrap-css');
        function changeCSS(css){
            if(css) $('head > link').filter(':first').replaceWith('<link rel="stylesheet" href="'+ css +'" type="text/css" />'); 
            else $('head > link').filter(':first').replaceWith(defaultCSS); 
        }
        $( document ).ready(function() {
          var iframe_height = parseInt($('html').height()); 
          window.parent.postMessage( iframe_height, 'http://bootsnipp.com');
        });
    </script>
</head>
<body>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<body>

<nav class="navbar navbar-default navbar-inverse" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="indexAdmin.php" style="color: #fff;"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Inicio</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="clientes.php" style="color: #fff;"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Clientes</a></li>
        <li>
        <form class="navbar-form navbar-left" role="search" method="get" action="auto.php">
	  <div class="form-group">
	    <input type="text" name="placas" class="form-control" placeholder="Buscar placas" required/>
	  </div>
	  <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
	</form>
        </li>
        <li><a href="ordenes.php" style="color: #fff;"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Órdenes de Servicio</a></li>
        <li><a href="presupuestos.php" style="color: #fff;"><span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Presupuestos</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      	<?php
      		if(!empty($usr)){
      		echo "<li><a name='#' style='color: #fff;'><span class='glyphicon glyphicon-user' aria-hidden='true'></span> " . $_SESSION['nombre'] . "</a></b></li>";
      	?>
      		<li><a href="logout.php" style="color: #fff;"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Salir</a></li>
      	<?php
      		}
      	?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


</body>
	<script type="text/javascript">
	</script>
	
</body>
</html>
