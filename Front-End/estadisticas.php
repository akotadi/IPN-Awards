<?php
require '../Back-End/PHP/connection_DB.php';

session_start();

if (isset($_SESSION["user"])) {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

		$connection = connect();

		$now = time();
		if ($now > $_SESSION['expire_time']) {
			error_log("Expired time", 3, "../logs/php_error.log");
			session_destroy();
			header("Location: ./index.html");
		} else {
			$_SESSION['expire_time'] = $now + (30 * 60);
		}

        $sqlGetPremios = "SELECT * FROM award";
        $sqlGetEscuelas = "SELECT * FROM procedency";

        $NombresPremios = "";
        $NombresEscuelas = "";
		$resultUser1     = $connection->query($sqlGetPremios);
		if ($resultUser1->num_rows > 0) {
			while ($extractUser1 = $resultUser1->fetch_assoc()) {
				$NombresPremios .= "
                    <option value=". $extractUser1['idaward'] .">".$extractUser1['name']."</option>"; 
            }
        }
        $resultUser2     = $connection->query($sqlGetEscuelas);
        if ($resultUser2->num_rows > 0) {
            while ($extractUser2 = $resultUser2->fetch_assoc()) {
                $NombresEscuelas .= "
                    <option value=". $extractUser2['idProcedency'] .">".$extractUser2['name']."</option>"; 
            }    
        
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Estadisticas</title>
    <meta name="description" content="Proyecto final para la materia de Tecnologías para la Web.">

    <!-- Font Awesome JS -->
    <link rel="stylesheet" href="css/fontawesome-free-5.3.1-web/css/all.min.css">

    <!-- Materialize Icons -->
    <link href="css/icon.css" rel="stylesheet">

    <!-- Compiled and Materialize minified CSS -->
    <link rel="stylesheet" href="css/materialize.min.css">

    <!-- Compiled and minified Materialize JavaScript -->
    <script src="js/materialize.min.js"></script>

    <!-- JQuery -->
    <script src="js/jquery.min.js"></script>

    <!-- Validetta -->
    <link rel="stylesheet" type="text/css" href="js/validetta/validetta.min.css">
    <script type="text/javascript" src="js/validetta/validetta.min.js"></script>
    <script type="text/javascript" src="js/validetta/localization/validettaLang-es-ES.js"></script>

    <!-- CANVAS -->
    <script type="text/javascript" src="js/jquery.canvasjs.min"></script>

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/invitados.css">

</head>

<body class="pink darken-3">
    <!-- Navigation section -->
    <!-- Navbar -->
    <nav class="pink darken-4">
        <div class="nav-wrapper">
            <a href="#!" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <a href="home.php" class="brand-logo">IPN</a>
            <ul class="right hide-on-med-and-down">
                <li><a href="asistencia.php" class="waves-effect waves-light">Asistencias</a></li>
                <li><a href="invitados.php" class="waves-effect waves-light">Invitados</a></li>
                <li><a href="usuarios.php" class="waves-effect waves-light">Usuarios</a></li>
                <li><a href="estadisticas.php" class="waves-effect waves-light">Estadisticas</a></li>
                <li><a href="perfil.php" class="waves-effect waves-light"><i class="material-icons">person</i></a></li>
            </ul>
        </div>
    </nav>
    <!-- /Navbar -->

    <!-- Sidenav -->
    <ul id="slide-out" class="sidenav">
        <li>
            <div class="user-view">
                <div class="background">
                    <img src="img/sidenav-bg.png" class="responsive-img">
                </div>
                <a href="#user"><img class="circle" src="img/ipn-logo.png"></a>
                <a href="#name"><span class="white-text name">Usuario generico</span></a>
                <a href="#email"><span class="white-text email">user@mail.com</span></a>
            </div>
        </li>
        <li><a href="asistencia.php" class="waves-effect">Asistencias</a></li>
        <li><a href="invitados.php" class="waves-effect">Invitados</a></li>
        <li><a href="usuarios.php" class="waves-effect">Usuarios</a></li>
        <li><a href="estadisticas.php" class="waves-effect">Estadisticas</a></li>
        <li>
            <div class="divider"></div>
        </li>
        <li><a href="perfil.php" class="waves-effect">Perfil</a></li>
    </ul>
    <!-- /Sidenav -->
    <!-- /Navigation section -->

    <!-- Main -->
    <form id="FormAssistance">
        <div class="row">
            <div class="col s12">
                <h1 class="left-align">Estadisticas</h1>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m10 offset-m1 white">
            <form id="DatosEstadistica">
                <div class="row">
                    <div class="input-field col s12">
                        <select id="calculo">
                        <option value="" disabled selected>Escoge el premio</option>
                        <?php
echo $NombresPremios;
			            ?>
                        </select>
                        <label>PREMIOS</label>
                    </div>
                    <div class="input-field col s12">
                        <select id="calculo">
                        <option value="" disabled selected>Escoge la escuela</option>
                        <?php
echo $NombresEscuelas;
			            ?>
                        </select>
                        <label>ESCUELAS</label>
                    </div>
            
                </div>
            </form>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <button href="" class="waves-effect waves-light btn pink darken-4 modal-trigger" type="submit" data-target="stats-modal" id="btnEstadistica">Estadisticas</button>
                    </div>
                    <div class="input-field col s12 m4">
                        <button class="waves-effect waves-light btn pink darken-4" type="submit" id="btnReporte">Generar reporte</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div id="stats-modal" class="modal">
        <div class="modal-content">
            <form id="FormCommentaries">
                <div class="row">
                    <div class="col s12">
                        <h1>Estadisticas</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                    <?php

                    ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col s4">
                        <button class="waves-effect waves-purple btn-flat modal-close" type="submit" id="btnUAssistant">Aceptar</button>
                    </div>
                    <div class="col s4">
                        <a href="#!" class="waves-effect waves-light btn-flat modal-close">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /Main -->

    <!-- Extras -->
    <!-- Modal -->

    <!-- /Modal -->
    <!-- /Extras -->

</body>

<!-- Our Custom JS -->
<script src="scripts/estadisticas.js"></script>

</html>
<?php
}
	} else {
		error_log("Not loggedin", 3, "../logs/php_error.log");
		session_destroy();
		header("location:./index.html");
	}
} else {
	error_log("Not session", 3, "../logs/php_error.log");
	session_destroy();
	header("Location: ./index.html");
}
?>