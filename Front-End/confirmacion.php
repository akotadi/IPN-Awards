<?php
session_start();

require '../Back-End/PHP/connection_DB.php';

if (isset($_GET) && !empty($_GET)) {

	$rfc  = $_GET["rfc"];
	$code = $_GET["code"];

	if (!empty($rfc) && !empty($code)) {
		$connection = connect();

		$rfc  = mysqli_real_escape_string($connection, $rfc);
		$code = mysqli_real_escape_string($connection, $code);

		$query = "SELECT * FROM awarded WHERE rfc = '" . $rfc . "'";

		$resultawarded = $connection->query($query);
		if ($resultawarded->num_rows > 0) {
			$extractawarded = $resultawarded->fetch_assoc();
			if ($code == $extractawarded['activation_code']) {
				$uQuery = "UPDATE awarded SET confirmed = 1 WHERE rfc = '$rfc'";
				if (!($connection->query($uQuery))) {
					error_log("Can't update", 3, "../logs/php_error.log");
					session_destroy();
					header("Location: ./index.html");
				}
			} else {
				error_log("Not valid activation code", 3, "../logs/php_error.log");
				session_destroy();
				header("Location: ./index.html");
			}
		} else {
			error_log("Not exist " . $rfc, 3, "../logs/php_error.log");
			session_destroy();
			header("Location: ./index.html");
		}
		mysqli_free_result($resultawarded);
		close($connection);
	} else {
		error_log("Not parameters", 3, "../logs/php_error.log");
		session_destroy();
		header("Location: ./index.html");
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

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/confirmacion.css">

</head>

<body class="pink darken-3">
    <!-- Navigation section -->
    <!-- Navbar -->
    <nav class="pink darken-4">
        <div class="nav-wrapper">
            <a href="index.html" class="brand-logo">IPN</a>
        </div>
    </nav>
    <!-- /Navbar -->
    <!-- /Navigation section -->

    <!-- Main -->
    <div class="row">
        <div class="col s12">
            <h1 class="center-align white-text">¡Tu asistencia está confirmada!</h1>
        </div>
    </div>
    <div class="row">
        <div id="login-container" class="col s6 white">
            <form id="FormCommentaries">
                <div class="row">
                    <div class="col s12">
                        <h1>A&ntildeadir Comentarios</h1>
                    </div>
                </div>
                <div class="row">
                    <form id="FormConfirmation">
                        <div class="input-field col s12">
                            <select multiple="multiple" name="multiple" id="asist-select" data-validetta="required,minSelected[1]">
                                <option value="" disabled selected>Elige opcion</option>
                                <option value="capacidad_diferente">Capacidad diferente</option>
                                <option value="silla_de_ruedas">Silla de ruedas</option>
                                <option value="se_retira_temprano">Se retira temprano</option>
                                <option value="acompaniante">Acompa&ntildeante (ayudante)</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="otherInput" type="text" class="validate" name="otherInput">
                        <label id="otherLabel" for="otherInput">Agrega comentario</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <button class="waves-effect waves-purple btn-flat modal-close" type="submit" id="btnUAssistant">Aceptar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- /Main -->
    <!-- Extras -->
    <!-- /Extras -->

</body>

<!-- Our Custom JS -->
<script src="scripts/confirmacion.js"></script>

</html>
<?php
} else {
	error_log("Not get", 3, "../logs/php_error.log");
	session_destroy();
	header("Location: ./index.html");
}
?>