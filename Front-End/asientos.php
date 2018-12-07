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
<html class="full-height" lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home</title>
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

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/home.css">

</head>

<body>
<!-- Navigation Section -->
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
		echo "<li><a href='.asientos.php' target='_blank' class='waves-effect waves-light' id='asientos'>Asientos</a></li>";

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
<!-- /Navigation Section -->

<!-- Background -->
<div id="bgimg" class="bgimg-1"></div>
<!-- /Background -->

<!-- Main -->
<div class="caption">
    <span class="border">CEREMONIA</span><br><br><br>
    <span class="border">GALARDONES</span><br><br><br>
    <span class="border">IPN</span>
</div>
<!-- /Main -->

</body>

<!-- Our Custom JS -->
<script src="scripts/home.js"></script>

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