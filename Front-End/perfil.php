<?php
session_start();
if (isset($_SESSION["user"])) {
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

		$now = time();
		if ($now > $_SESSION['expire_time']) {
			error_log("Expired time", 3, "../logs/php_error.log");
			session_destroy();
			header("Location: ./index.html");
		} else {
			$_SESSION['expire_time'] = $now + (30 * 60);
		}
		?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Perfil</title>
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
    <link rel="stylesheet" href="styles/perfil.css">

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
    <div class="row">
        <div id="login-container" class="col s6 white">
            <ul id="menu-collapsible" class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="fas fa-envelope"></i>Cambiar Email</div>
                    <div class="collapsible-body">
                        <form id="FormChangeEmail">
                            <div class="row">
                                <div class="input-field col s8">
                                    <input id="old-email" type="email" class="validate" name="old-email" data-validetta="required,email">
                                    <label for="old-email">Email actual</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s8">
                                    <input id="new-email" type="email" class="validate" name="new-email" data-validetta="required,email,different[old-email]">
                                    <label for="new-email">Nuevo email</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s8">
                                    <input id="new-email-confirm" type="email" class="validate" name="new-email-confirm"
                                        data-validetta="required,email,equalTo[new-email]">
                                    <label for="new-email-confirm">Confirma nuevo email</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m3">
                                    <button class="waves-effect waves-light btn pink darken-4" type="submit" id="btnChangeEmail">Actualizar
                                        Correo</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="fas fa-key"></i>Cambiar contrase&ntilde;a</div>
                    <div class="collapsible-body">
                        <form id="FormChangePassword">
                            <div class="row">
                                <div class="input-field col s8">
                                    <input id="email" type="email" class="validate" name="email"
                                        data-validetta="required,email">
                                    <label for="email">Email actual</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s8">
                                    <input id="old-password" type="password" class="validate" name="old-password"
                                        data-validetta="required,minLength[4],maxLength[16]">
                                    <label for="old-password">Contrase&ntilde;a actual</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s8">
                                    <input id="new-password" type="password" class="validate" name="new-password"
                                        data-validetta="required,minLength[4],maxLength[16],different[old-password]">
                                    <label for="new-password">Nueva contrase&ntilde;a</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s8">
                                    <input id="new-password-confirm" type="password" class="validate" name="new-password-confirm"
                                        data-validetta="required,minLength[4],maxLength[16],equalTo[new-password]">
                                    <label for="new-password-confirm">Confirmar nueva contrase&ntilde;a</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m3">
                                    <button class="btn waves-effect waves-light btn pink darken-4" type="submit" id="btnChangePassword">Actualizar
                                        Contrase&ntilde;a</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="fas fa-user-times"></i>Eliminar cuenta</div>
                    <div class="collapsible-body">
                        <div class="row">
                            <p>
                                Al eliminar tu cuenta se perderán todos tus datos.
                                Esta acción no se puede deshacer.
                            </p>
                        </div>
                        <div class="row">
                            <a href="#!" class="btn modal-trigger waves-effect waves-light pink darken-4" data-target="delete-modal">Elimnar
                                cuenta</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="fas fa-sign-out-alt"></i>Desconectar</div>
                    <div class="collapsible-body">
                            <div class="row">
                                <a id="btnCloseSession" href="" class="btn waves-effect waves-light pink darken-4" >Cerrar
                                    sesión</a>
                            </div>
                    </div>
                </li>
            </ul>
        </div>
        <!-- /Main -->

        <!-- Extras -->
        <!-- Modal -->
        <div id="delete-modal" class="modal">
            <div class="modal-content">
                <form id="FormDelete">
                    <div class="row">
                        <div class="col s12">
                            <h4>Eliminar cuenta?</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <p>
                                Al eliminar tu cuenta se perderán todos tus datos.
                                Esta acción no se puede deshacer.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="user" type="text" class="validate" name="user" data-validetta="required">
                            <label for="user">Usuario</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password" type="password" class="validate" name="password" data-validetta="required,minLength[4],maxLength[16]">
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s4">
                            <button class="btn waves-effect waves-light btn pink darken-4" type="submit" id="btnDelete">Eliminar cuenta</button>
                        </div>
                        <div class="col s4">
                            <a href="#!" class="btn-flat modal-close waves-effect waves-light darken-4">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Modal -->
        <!-- /Extras -->

</body>

<!-- Our Custom JS -->
<script src="scripts/perfil.js"></script>

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