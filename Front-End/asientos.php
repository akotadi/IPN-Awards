<?php
require '../Back-End/PHP/connection_DB.php';

session_start();

if (isset($_SESSION["user"]) && $_SESSION["type"] == 2) {
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

		$sqlGetInvitados = "SELECT * FROM awarded WHERE confirmed = 1";

		$filasInvitados  = "";
		$resultInvitados = $connection->query($sqlGetInvitados);
		$asiento         = 0;
		if ($resultInvitados->num_rows > 0) {
			while ($extractInvitado = $resultInvitados->fetch_assoc()) {
				$filasInvitados .= "
                    <tr id='" . $extractInvitado['rfc'] . "' class='not-selected'>
                        <td class='name'>" . $extractInvitado['name'] . ' ' . $extractInvitado['first_surname'] . ' ' . $extractInvitado['second_surname'] . "</td>
                        <td class='name'>" . ++$asiento . "</td>
                    </tr>
                    ";
			}
		}
		?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invitados</title>
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

    <!-- Codemirror -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>

    <!-- Froala Editor -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/js/froala_editor.pkgd.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/js/languages/es.js"></script>

    <!-- Codemirror -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/codemirror.min.css">

    <!-- Froala Editor -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/css/froala_style.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/css/froala_editor.pkgd.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/css/themes/royal.min.css">

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

<?php

		if ($_SESSION["type"] == 2 || $_SESSION["type"] == 3) {
			echo "<li><a href='./avisos.php' class='waves-effect waves-light' id='avisos'>Avisos</a></li>";
		}
		if ($_SESSION["type"] == 2 || $_SESSION["type"] == 5) {
			echo "<li><a href='../Back-End/PHP/createSpeech.php' target='_blank' class='waves-effect waves-light' id='discurso'>Discurso</a></li>";
		}
		if ($_SESSION["type"] == 2 || $_SESSION["type"] == 4) {
			echo "<li><a href='./asistencia.php' class='waves-effect waves-light'>Asistencias</a></li>";
		}
		if ($_SESSION["type"] == 2) {
			echo "<li><a href='./invitados.php' class='waves-effect waves-light'>Invitados</a></li>";
		}
		if ($_SESSION["type"] == 2 || $_SESSION["type"] == 1) {
			echo "<li><a href='./usuarios.php' class='waves-effect waves-light'>Usuarios</a></li>";
		}
		if ($_SESSION["type"] == 2) {
			echo "<li><a href='./estadisticas.php' class='waves-effect waves-light'>Estadisticas</a></li>";
		}

		?>
                <li><a href="./perfil.php" class="waves-effect waves-light"><i class="material-icons">person</i></a></li>
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

<?php

		if ($_SESSION["type"] == 2 || $_SESSION["type"] == 3) {
			echo "<li><a href='./avisos.php' class='waves-effect'>Avisos</a></li>";
		}
		if ($_SESSION["type"] == 2 || $_SESSION["type"] == 5) {
			echo "<li><a href='../Back-End/PHP/createSpeech.php' target='_blank' class='waves-effect' id='discurso'>Discurso</a></li>";
		}
		if ($_SESSION["type"] == 2 || $_SESSION["type"] == 4) {
			echo "<li><a href='./asistencia.php' class='waves-effect'>Asistencias</a></li>";
		}
		if ($_SESSION["type"] == 2) {
			echo "<li><a href='./invitados.php' class='waves-effect'>Invitados</a></li>";
		}
		if ($_SESSION["type"] == 2 || $_SESSION["type"] == 1) {
			echo "<li><a href='./usuarios.php' class='waves-effect'>Usuarios</a></li>";
		}
		if ($_SESSION["type"] == 2) {
			echo "<li><a href='./estadisticas.php' class='waves-effect'>Estadisticas</a></li>";
		}
		?>
        <li>
            <div class="divider"></div>
        </li>
        <li><a href="./perfil.php" class="waves-effect">Perfil</a></li>
    </ul>
    <!-- /Sidenav -->
    <!-- /Navigation section -->

    <!-- Main -->
    <div class='row' style='height=25%'></div>
        <div class="row">
            <div class="col s12 m10 offset-m1 white">
                <div class="row">
                    <div class="col s12">
                        <h1 class="left-align">Asientos</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col 12 m8">
                        <input id="browser-input" type="text" class="validate" name="browser-input" onkeyup="searchAsist()">
                        <label for="browser-input">Buscar...</label>
                    </div>
                </div>
                <div class="row">
                    <table id="tabla-invitados" class="responsive-table">
                        <thead>
                            <tr>
                                <th style="width:50%;">Invitado</th>
                                <th style="width:20%;">Asiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
if ($resultInvitados->num_rows > 0) {
			echo $filasInvitados;
		}
		?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- /Main -->

    <!-- Extras -->
    <!-- /Extras -->

</body>

<!-- Our Custom JS -->
<script src="scripts/invitados.js"></script>

</html>
<?php
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