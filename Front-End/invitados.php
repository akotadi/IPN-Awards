<?php
    session_start();
    include("../Back-End/PHP/connection_DB.php");
    if(isset($_SESSION["usuario"])){
        $sqlGetInvitados = "SELECT * FROM Awarded";
        $resGetInvitados = mysqli_query($conexion,$sqlGetInvitados);
        $filasInvitados = "";
        while($filas = mysqli_fetch_array($resGetInvitados,MYSQLI_BOTH)){
            $filasInvitados .= '
                    <tr class="not-selected">
                        <td>$filas[1] $filas[2] $filas[3]</td>
                        <td>$filas[7]</td>
                        <td id="$filas[0]">
                            <a href="#!" class="edit waves-effect waves-light modal-trigger" data-target="asist-modal"><i
                                class="material-icons left">add</i></a>
                            <a class="search waves-effect waves-light"><i class="material-icons left">search</i></a>
                            <a class="delete waves-effect waves-light"><i class="material-icons left">delete_forever</i></a>
                        </td>
                    </tr>
                    ';
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
    <link rel="stylesheet" href="styles/invitados.css">

</head>

<body class="pink darken-3">
    <!-- Navigation section -->
    <!-- Navbar -->
    <nav class="pink darken-4">
        <div class="nav-wrapper">
            <a href="#!" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <a href="home.html" class="brand-logo">IPN</a>
            <ul class="right hide-on-med-and-down">
                <li><a href="asistencia.html" class="waves-effect waves-light">Asistencias</a></li>
                <li><a href="invitados.html" class="waves-effect waves-light">Invitados</a></li>
                <li><a href="usuarios.html" class="waves-effect waves-light">Usuarios</a></li>
                <li><a href="estadisticas.html" class="waves-effect waves-light">Estadisticas</a></li>
                <li><a href="#" class="waves-effect waves-light"><i class="material-icons">person</i></a></li>
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
        <li><a href="asistencia.html" class="waves-effect">Asistencias</a></li>
        <li><a href="invitados.html" class="waves-effect">Invitados</a></li>
        <li><a href="usuarios.html" class="waves-effect">Usuarios</a></li>
        <li><a href="estadisticas.html" class="waves-effect">Estadisticas</a></li>
        <li>
            <div class="divider"></div>
        </li>
        <li><a href="#" class="waves-effect">Perfil</a></li>
    </ul>
    <!-- /Sidenav -->
    <!-- /Navigation section -->

    <!-- Main -->
    <form id="FormAssistance">
        <div class="row">
            <div class="col s12">
                <h1 class="left-align">Invitados</h1>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m10 offset-m1 white">
                <div class="row">
                    <div class="input-field col s12 m4">
                        <a class="waves-effect waves-light btn pink darken-4" type="submit" id="btnCAssistant">A&ntildeadir invitados</a>
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
                    <table id="tabla-invitados" class="responsive-table">
                        <thead>
                            <tr>
                                <th>Invitado</th>
                                <th>Confirmado</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $filasInvitados;
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <a class="waves-effect waves-light btn pink darken-4" type="submit" id="btnInvitacion">Enviar
                            Invitacion</a>
                    </div>
                    <div class="input-field col s12 m4">
                        <a class="waves-effect waves-light btn pink darken-4" type="submit" id="btnAviso">Enviar Aviso</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- /Main -->

    <!-- Extras -->
    <!-- Modal -->

    <!-- /Modal -->
    <!-- /Extras -->

</body>

<!-- Our Custom JS -->
<script src="scripts/invitados.js"></script>

</html>
<?php
}else{
    header("location:../Front-End/index.html");
}
?>