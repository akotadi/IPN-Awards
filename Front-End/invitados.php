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

		$sqlGetInvitados = "SELECT * FROM awarded";

		$filasInvitados = "";
		$resultInvitados     = $connection->query($sqlGetInvitados);
		if ($resultInvitados->num_rows > 0) {
			while ($extractInvitado = $resultInvitados->fetch_assoc()) {
				$filasInvitados .= "
                    <tr id='" . $extractInvitado['rfc'] . "' class='not-selected'>
                        <td class='name'>" . $extractInvitado['name'] . ' ' . $extractInvitado['first_surname'] . ' ' . $extractInvitado['second_surname'] . "</td>
                        <td class='name'>" . (($extractInvitado['confirmed'] == 0) ? (' ') : ('<i class="material-icons">check</i>')) . "</td>
                        <td>
                            <a id='" . $extractInvitado['rfc'] . "' class='waves-effect waves-light modal-trigger' data-target='asist-modal'><i
                                class='material-icons left'>add</i></a>
                            <a id='" . $extractInvitado['rfc'] . " 2' class='search waves-effect waves-light'><i class='material-icons left'>search</i></a>
                            <a id='" . $extractInvitado['rfc'] . " 3' class='delete-rfc waves-effect waves-light'><i class='material-icons left'>delete_forever</i></a>
                        </td>
                    </tr>
                    ";
            }
        }

        $sqlGetProcedency = "SELECT idProcedency, name FROM procedency;";

        $getProcedency = "";
		$resultProcedency     = $connection->query($sqlGetProcedency);
		if ($resultProcedency->num_rows > 0) {
			while ($extractProcedency = $resultProcedency->fetch_assoc()) {
				$getProcedency .= "
                    <option value='".$extractProcedency['idProcedency']."'>".$extractProcedency['name']."</option>
                    ";
            }
        }

        $sqlGetAward = "SELECT idaward, name FROM award;";

        $getAward = "";
		$resultAward     = $connection->query($sqlGetAward);
		if ($resultAward->num_rows > 0) {
			while ($extractAward = $resultAward->fetch_assoc()) {
				$getAward .= "
                    <option value='".$extractAward['idaward']."'>".$extractAward['name']."</option>
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
    <div class='row' style='height=25%'></div>
        <div class="row">
            <div class="col s12 m10 offset-m1 white">
                <div class="row">
                    <div class="col s12">
                        <h1 class="left-align">Invitados</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <a class="waves-effect waves-light modal-trigger btn pink darken-4" data-target="add-modal" href="#!" id="btnAdd">A&ntildeadir invitados</a>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col 12 m8">
                        <input id="browser-input" type="text" class="validate" name="browser-input" onkeyup="searchAsist()">
                        <label for="browser-input">Buscar...</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <a class="waves-effect waves-light btn pink darken-4" id="btnCSelect" onclick="selectAll()">Seleccionar
                            todos</a>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <a class="waves-effect waves-light btn pink darken-4" id="btnInvitacion">Enviar
                            Invitacion</a>
                    </div>
                    <div class="input-field col s12 m4">
                        <a class="waves-effect waves-light btn modal-trigger pink darken-4" data-target="aviso-modal">Enviar Aviso</a>
                    </div>
                </div>
                <div class="row">
                    <table id="tabla-invitados" class="responsive-table">
                        <thead>
                            <tr>
                                <th style="width:50%;">Invitado</th>
                                <th style="width:20%;">Confirmado</th>
                                <th style="width:30%;">Accion</th>
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
    <!-- Modal Enviar Aviso -->
    <div id="aviso-modal" class="modal">
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <h1>Aviso</h1>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="asunto" type="text" class="validate" name="asunto">
                    <label for="asunto">Asunto</label>
                </div>
            </div>
            <form class="text-center border border-light p-5 col" id="formText">
                <div class="row justify-content-center">
                    <div class="col s12">
                        <textarea id="text"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col s4">
                        <button class="waves-effect waves-purple btn-flat modal-close" type="submit" id="btnSendEmail">Enviar</button>
                    </div>
                    <div class="col s4">
                        <a href="#!" class="waves-effect waves-light btn-flat modal-close">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /Modal Enviar Aviso -->
    <!-- Modal Add Gest -->
    <div id="add-modal" class="modal">
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <h1>Aviso</h1>
                </div>
            </div>
            <form id="FormAdd">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="rfc" type="text" class="validate" name="rfc">
                        <label for="rfc">RFC</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name" type="text" class="validate" name="name">
                        <label for="name">Nombre</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="first_surname" type="text" class="validate" name="first_surname">
                        <label for="first_surname">Primer apellido</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="second_surname" type="text" class="validate" name="second_surname">
                        <label for="second_surname">Segundo apellido</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="email" type="email" class="validate" name="email">
                        <label for="email">Correo electrónico</label>
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
                        <label>Procedencia</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select id="award-select" data-validetta="required">
                            <?php
                            if ($resultAward->num_rows > 0) {
                                echo $getAward;
                            }
                            ?>
                        </select>
                        <label>Procedencia</label>
                    </div>
                </div>
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