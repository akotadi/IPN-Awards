<?php
require '../Back-End/PHP/connection_DB.php';

session_start();

if (isset($_SESSION["user"]) && ($_SESSION["type"] == 2 || $_SESSION["type"] == 1)) {
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

		$sqlGetInvitados = "";

		if ($_SESSION["type"] == 1) {
			$sqlGetInvitados = "SELECT * FROM user WHERE idType = 2";
		} else if ($_SESSION["type"] == 2) {
			$sqlGetInvitados = "SELECT * FROM user WHERE idType > 2";
		} else {
			session_destroy();
			header("Location: ./index.html");
		}

		$sqlGetProcedency = "SELECT idtype, name FROM type";

		$getProcedency    = "";
		$resultProcedency = $connection->query($sqlGetProcedency);
		if ($resultProcedency->num_rows > 0) {
			while ($extractProcedency = $resultProcedency->fetch_assoc()) {
				$getProcedency .= "
                <option value='" . $extractProcedency['idtype'] . "'>" . $extractProcedency['name'] . "</option>
                ";
			}
		}

		$filasUsuarios = "";
		$resultUser    = $connection->query($sqlGetInvitados);
		if ($resultUser->num_rows > 0) {
			while ($extractUser = $resultUser->fetch_assoc()) {
				$filasUsuarios .= "
                <tr>
                    <td>" . $extractUser['username'] . "</td>
                    <td>

                        <a id='" . $extractUser['username'] . "' class='delete waves-effect waves-light'><i class='material-icons left'>delete_forever</i></a>
                    </td>
                </tr>
                ";
			}
			?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Usuarios</title>
    <meta name="description" content="Proyecto final para la materia de Tecnologías para la Web.">

    <!-- Font Awesome JS -->
    <link rel="stylesheet" href="css\fontawesome-free-5.3.1-web\css\all.min.css">

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

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/usuarios.css">

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
    <form id="FormAssistance">
        <div class="row">
            <div class="col s12">
                <h1 class="left-align">Usuarios</h1>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m10 offset-m1 white">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <a class="waves-effect waves-light modal-trigger btn pink darken-4" data-target="add-modal" href="#!" id="btnAdd">A&ntildeadir usuario</a>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col 12 m8">
                        <input id="browser-input" type="text" class="validate" name="browser-input" onkeyup="searchAsist()">
                        <label for="browser-input">Buscar...</label>
                    </div>
                </div>
                <div class="row">
                    <table id="tabla-usuarios" class="responsive-table">
                        <thead class="header">
                            <tr>
                                <th style="width:70%;">Usuario</th>
                                <th style="width:30%;">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
echo $filasUsuarios;
			?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
    <!-- /Main -->

    <!-- Extras -->
    <!-- Modal Add Gest -->
    <div id="add-modal" class="modal">
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <h1 class="black-text">Usuario</h1>
                </div>
            </div>
            <form id="FormAdd">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="user" type="text" class="validate" name="user">
                        <label for="user">Username</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="email" type="email" class="validate" name="email">
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="password" type="password" class="validate" name="password">
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select id="procedency-select" data-validetta="required">
                            <?php

			if ($resultProcedency->num_rows > 0) {
				echo $getProcedency;
			}
			?>
                        </select>
                        <label>Tipo</label>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col s4">
                        <button class="waves-effect waves-purple btn-flat modal-close" type="submit" id="btnAdd">Enviar</button>
                    </div>
                    <div class="col s4">
                        <a href="#!" class="waves-effect waves-light btn-flat modal-close">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /Modal Add Gest -->
    <!-- Modal -->

    <!-- /Modal -->
    <!-- /Extras -->

</body>

<!-- Our Custom JS -->
<script src="scripts/usuarios.js"></script>

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