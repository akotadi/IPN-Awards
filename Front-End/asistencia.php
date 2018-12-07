<?php
require '..\Back-End\PHP\connection_DB.php ';

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

		$query = "SELECT * FROM awarded";

		$filasInvitados = "";
		$resultUser     = $connection->query($query);
		if ($resultUser->num_rows > 0) {
			while ($extractUser = $resultUser->fetch_assoc()) {
				$filasInvitados .= "
                    <tr>
                        <td>" . $extractUser['name'] . " " . $extractUser['first_surname'] . " " . $extractUser['second_surname'] . "</td>
                        <td>
                            <a id='" . $extractUser['rfc'] . "' href='' class='waves-effect waves-light modal-trigger' data-target='asist-modal'><i
                                class='material-icons left'>add</i></a>
                            <a id='" . $extractUser['rfc'] . "' class='delete-rfc waves-effect waves-light'><i class='material-icons left'>delete_forever</i></a>
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
    <title>Asistencia</title>
    <meta name="description" content="Proyecto final para la materia de Tecnologías para la Web.">

    <!-- Font Awesome JS -->
    <link rel="stylesheet" href="css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
        crossorigin="anonymous">

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

</head>

<body class="pink darken-3">

    <!-- Navigation section -->
    <!-- Navbar -->
    <nav class="pink darken-4">
        <div class="nav-wrapper">
            <a href="#!" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <a href="index.html" class="brand-logo">IPN</a>
            <ul class="right hide-on-med-and-down">
                <li><a href="#" class="waves-effect waves-light">Asistencias</a></li>
                <li><a href="invitados.php" class="waves-effect waves-light">Invitados</a></li>
                <li><a href="usuarios.php" class="waves-effect waves-light">Usuarios</a></li>
                <li><a href="#" class="waves-effect waves-light">Estadisticas</a></li>
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
        <li><a href="#" class="waves-effect">Asistencias</a></li>
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
    <div class="row" style="height: 10%"></div>
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <div class="row white">
                <div class="col s12">
                    <!-- Tab Menu -->
                    <ul id="tabs-asistencia" class="tabs">
                        <li class="tab col s6"><a href="#tab1">A&ntildeadir invitado</a></li>
                        <li class="tab col s6"><a href="#tab2">Buscar invitado</a></li>
                    </ul>
                    <!-- /Tab Menu -->
                </div>
                <!-- Tab1 -->
                <div id="tab1" class="col s12">
                    <form id="FormAssistance">
                        <h1 class="left-align">A&ntildeadir invitado</h1>
                        <div class="row">
                            <div class="input-field col s8">
                                <input id="qrcode-text" type="text" class="qrcode-text validate" name="rfc"
                                    data-validetta="required,minLength[10],maxLength[10]">
                                <label for="qrcode-text">RFC</label>
                                <label for="qrcode-text">RFC:</label>
                            </div>
                            <div class="input-field col s3">
                                <button class="btn waves-effect waves-light pink darken-4 modal-trigger" href="#"
                                    data-target="qr-modal" onclick="startQRReader()">QR</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s3">
                                <button class="waves-effect waves-light btn pink darken-4" type="submit" id="btnCAssistant">A&ntildeadir</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /Tab1 -->
                <!-- Tab2 -->
                <div id="tab2" class="col s12">
                    <h1 class="left-align">Buscar invitado</h1>
                    <div class="row">
                        <div class="input-field col s8">
                            <input id="browser-input" type="text" class="validate" name="browser-input" onkeyup="searchAsist()">
                            <label for="browser-input">Buscar...</label>
                        </div>
                    </div>
                    <div class="row">
                        <table id="asist-table">
                            <thead>
                                <tr class="header">
                                    <th style="width:70%;">Invitado</th>
                                    <th style="width:30%;">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    echo $filasInvitados;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /Tab2 -->
            </div>
        </div>
    </div>
    <!-- /Main -->

    <!-- Extras -->
    <!-- Modal Comentarios -->
    <div id="asist-modal" class="modal">
        <div class="modal-content">
            <form id="FormCommentaries">
                <div class="row">
                    <div class="col s12">
                        <h1>A&ntildeadir Comentarios</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <input disabled id="actual-rfc" type="text" class="validate">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select multiple id="asist-select" data-validetta="required,minSelected[1]">
                            <option id="op1" value="Capacidad diferente">Capacidad diferente</option>
                            <option id="op2" value="Silla ruedas">Silla ruedas</option>
                            <option id="op3" value="Representante">Representante</option>
                            <option id="op4" value="Se retira temprano">Se retira temprano</option>
                            <option id="op5" value="Acompañante (ayudante)">Acompa&ntildeante (ayudante)</option>
                            <option id="op6" value="Otro...">Otro</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="otherInput" type="text" class="validate" name="otherInput">
                        <label id="otherLabel" for="otherInput">Agrega comentario</label>
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
    <!-- /Modal Comentarios -->
    <!-- Modal QR -->
    <div id="qr-modal" class="modal">
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <h4>Lector QR</h4>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="preview-container">
                        <video id="preview" autoplay="autoplay" class="active responsive-video"></video>
                    </div>
                    <div id="listCameras" class="collection">
                    </div>
                    <div>
                        <button id="btnCloseModal" type="button" class="btn-flat modal-close waves-effect waves-light darken-4"
                            onclick="closeQRReader()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /Modal QR -->
    <!-- /Extras -->


</body>

<!-- Our Custom JS -->
<script src="scripts/asistencia.js"></script>
<script src="scripts/qr.js"></script>

<!-- QR Code Reader -->
<!-- <script src="js/qr_packed.js"></script> -->
<script type="text/javascript" src="js/instascan.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>

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