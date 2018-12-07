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

		$sqlGetPremios  = "SELECT * FROM award";
		$sqlGetEscuelas = "SELECT * FROM procedency";

		$NombresPremios  = "";
		$NombresEscuelas = "";
		$resultUser1     = $connection->query($sqlGetPremios);
		if ($resultUser1->num_rows > 0) {
			while ($extractUser1 = $resultUser1->fetch_assoc()) {
				$NombresPremios .= "
                    <option value=" . $extractUser1['idAward'] . ">" . $extractUser1['name'] . "</option>";
			}
		}
		$resultUser2 = $connection->query($sqlGetEscuelas);
		if ($resultUser2->num_rows > 0) {
			while ($extractUser2 = $resultUser2->fetch_assoc()) {
				$NombresEscuelas .= "
                    <option value=" . $extractUser2['idProcedency'] . ">" . $extractUser2['name'] . "</option>";
			}

			// Datos de areas
			$datosX = [3];

			for ($i = 0; $i < 3; $i++) {
				$sum        = $i + 1;
				$sqlGetAx   = "SELECT a.* FROM awarded a, procedency p, area ar WHERE ar.idArea = p.idArea AND p.idProcedency = a.idPRocedency AND a.is_present = 1 && ar.idArea = " . $sum . "";
				$resultUser = $connection->query($sqlGetAx);
				$datosX[$i] = mysqli_num_rows($resultUser);
			}

			// Datos de premios
			$datosP = [9];

			for ($j = 0; $j < 9; $j++) {
				$suma       = $j + 1;
				$sqlGetA3   = "SELECT a.* FROM awarded a, award aw WHERE aw.idAward = a.idAward AND  a.is_present = 1 && aw.idAward = " . $suma . "";
				$resultUser = $connection->query($sqlGetA3);
				$datosP[$j] = mysqli_num_rows($resultUser);

			}

			$totalInvitados  = "select * from Awarded";
			$totalAsistentes = "select * from Awarded where is_present = 1";

			$resultTotalInvitados  = $connection->query($totalInvitados);
			$resultTotalAsistentes = $connection->query($totalAsistentes);

			$cantInvitados  = mysqli_num_rows($resultTotalInvitados);
			$cantAsistentes = mysqli_num_rows($resultTotalAsistentes);

			$cantNoAsistentes = $cantInvitados - $cantAsistentes;

			// $nombresUnidades = [101];
			$cantTotalUnidades = [101];
			$cantAsistUnidades = [101];

			for ($s = 1; $s <= 101; $s++) {
				// $sentencia = "select name from Procedency where idProcedency = " . $s . "";
				// $resultUser = $connection->query($sentencia);
				// $nombresUnidades[$s - 1] = $resultUser;

				$sentencia2                = "select * from Awarded where idProcedency = " . $s . "";
				$resultUser                = $connection->query($sentencia2);
				$cuantosTotalEscuela       = mysqli_num_rows($resultUser);
				$cantTotalUnidades[$s - 1] = $cuantosTotalEscuela;

				$sentencia3                = "select * from Awarded where idProcedency = " . $s . " && is_present = 1";
				$resultUser                = $connection->query($sentencia3);
				$cuantosAsistEscuela       = mysqli_num_rows($resultUser);
				$cantAsistUnidades[$s - 1] = $cuantosAsistEscuela;
			}

			// echo $nombresUnidades[0];
			// echo $cantTotalUnidades[0];
			// echo "<br>";
			// echo $cantAsistUnidades[0];
			// echo "<br>";

			$unidades      = "SELECT * FROM Procedency";
			$Tablaescuelas = "";
			$s             = 0;
			$resulttabla   = $connection->query($unidades);
			if ($resulttabla->num_rows > 0) {
				while ($extractUser = $resulttabla->fetch_assoc()) {
					$Tablaescuelas .= "
                    <tr>
                        <td>" . $extractUser['name'] . " </td> <td> " . $cantTotalUnidades[$s] . " </td> <td> " . $cantAsistUnidades[$s] . "</td>
                    </tr>
                    ";
					$s++;
				}
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
<script>
 $(document).ready(function(){

    $(".calcular1").on("click",function(){

        var areas =  new CanvasJS.Chart("chartContainer", {
            title:{
                text: "AREAS"
            },
            axisY: {
                title: "Asistencia",
                // suffix: "%",
                includeZero: false
            },
            axisX: {
                title: "areas"
            },
            data:[{
                type: "column",
                dataPoints:[
                    {label: "Nivel Medio Superior", y: <?php echo $datosX[0] ?>},
                    {label: "Nivel Superior", y: <?php echo $datosX[1] ?> },
                    {label: "Area Central", y: <?php echo $datosX[2] ?>}
                ]
            }]
        });
        areas.render();
    });

    $(".calcular2").on("click",function(){
            var chart = new CanvasJS.Chart("chartContainer2", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "PREMIOS"
            },
            axisY: {
                title: "Asistencia",
                // suffix: "%",
                includeZero: false
            },
            axisX: {
                title: "premios"
            },
            data: [{
                type: "column",
                // yValueFormatString: "#,##0.0#\"%\"",
                // showInLegend: true;
                dataPoints:[
                    {label: "C", y: <?php echo $datosP[0] ?>},
                    {label: "E", y: <?php echo $datosP[1] ?> },
                    {label: "I", y: <?php echo $datosP[2] ?>},
                    {label: "D", y: <?php echo $datosP[3] ?>},
                    {label: "MD", y: <?php echo $datosP[4] ?>},
                    {label: "ME", y: <?php echo $datosP[5] ?>},
                    {label: "MP", y: <?php echo $datosP[6] ?>},
                    {label: "C", y: <?php echo $datosP[7] ?>},
                    {label: "J", y: <?php echo $datosP[8] ?>}

                ]
            }]
        });
        chart.render();

    });

    $(".calcular3").on("click",function(){
       var total =  new CanvasJS.Chart("chartContainer", {
            title:{
                text: "ASISTENCIA TOTAL"
            },

            data:[{
                type: "doughnut",
                indexLabelPlacement: "outside",
                showInLegend: true,
                dataPoints:[
                    { y: <?php echo $cantAsistentes ?>,name:"Asistieron"},
                    { y: <?php echo $cantNoAsistentes ?>,name:"No Asistieron"}
                ]
            }]
        });
        total.render();
    });
 });
</script>

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
				echo "<li><a href='' class='waves-effect waves-light' id='discurso'>Discurso</a></li>";
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
				echo "<li><a href=' class='waves-effect' id='discurso'>Discurso</a></li>";
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
                <h1 class="left-align">Estadisticas</h1>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m10 offset-m1 white">
            <form id="DatosEstadistica">
                <div class="row">
                </div>
            </form>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <button href="" class="waves-effect waves-light btn pink darken-4 modal-trigger calcular1" type="submit" data-target="stats-modal" id="btnEstadistica1">Estadisticas areas</button>
                    </div>
                    <div class="input-field col s12 m4">
                        <button href="" class="waves-effect waves-light btn pink darken-4 modal-trigger calcular2" type="submit" data-target="stats-modal2" id="btnEstadistica2">Estadisticas diplomas</button>
                    </div>
                    <div class="input-field col s12 m4">
                        <button href="" class="waves-effect waves-light btn pink darken-4 modal-trigger calcular3" type="submit" data-target="stats-modal" id="btnEstadistica3">Estadisticas asistencia total</button>
                    </div>
                    <div class="input-field col s12 m4">
                        <button href="" class="waves-effect waves-light btn pink darken-4 modal-trigger " type="submit" data-target="stats-modal3" id="btnEstadistica4">Estadisticas por unidad</button>
                    </div>
                    <div class="input-field col s12 m4">
                         <a class="waves-effect waves-light btn pink darken-4" href="../Back-End/PHP/createSpeech.php" target="_blank" id="btnReporte">Generar reporte</a>
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
                        <h1 style = "font-size: 5vw;">Estadisticas</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                    </div>
                    <!-- <div class="col s12">
                    <div id="chartContainerPREMIOS" style="height: 300px; width: 100%;"></div>
                    <div>
                    <div class="col s12">
                    <div id="chartContainerAREAS" style="height: 300px; width: 100%;"></div>
                    </div> -->
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

    <div id="stats-modal2" class="modal">
        <div class="modal-content">
            <form id="FormCommentaries">
                <div class="row">
                    <div class="col s12">
                        <h1 style = "font-size: 5vw;">Estadisticas</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                    <div id="chartContainer2" style="height: 300px; width: 100%;"></div>
                    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                    <p>
                        <br>
                        C = DIPLOMA A LA CULTURA <br>
                        E = DIPLOMA A LA EFICIENCIA Y EFICACIA<br>
                        I = INVESTIGACION<br>
                        D = DIPLOMA AL DEPORTE<br>
                        MD = DIPLOMA DE MAESTRO DECANO<br>
                        ME = DIPLOMA DE MAESTRO EMERITO<br>
                        MP = DIPLOMA AL MERITO POLITECNICO<br>
                        C = DIPLOMA CARLOS VALLEJO MARQUEZ<br>
                        J = DIPLOMA JUAN DE DIOS BATIZ<br>
                    </p>
                    </div>
                    <!-- <div class="col s12">
                    <div id="chartContainerPREMIOS" style="height: 300px; width: 100%;"></div>
                    <div>
                    <div class="col s12">
                    <div id="chartContainerAREAS" style="height: 300px; width: 100%;"></div>
                    </div> -->
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
    <div id="stats-modal3" class="modal">
        <div class="modal-content">
            <form id="FormCommentaries">
                <div class="row">
                    <div class="col s12">
                        <h1 style = "font-size: 5vw;">Estadisticas</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                    <div class="row">
                        <table id="asist-table">
                            <thead>
                                <tr class="header">
                                    <th style="width:50%;">Unidad</th>
                                    <th style="width:30%;">Total invitados</th>
                                    <th style="width:30%;">Total asistencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
echo $Tablaescuelas;
			?>
                            </tbody>
                        </table>
                    </div>
                    <!-- <div class="col s12">
                    <div id="chartContainerPREMIOS" style="height: 300px; width: 100%;"></div>
                    <div>
                    <div class="col s12">
                    <div id="chartContainerAREAS" style="height: 300px; width: 100%;"></div>
                    </div> -->
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