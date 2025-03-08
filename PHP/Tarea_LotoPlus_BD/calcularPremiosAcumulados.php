<?php
$titulo = "Cálculo premios acumulados | LotoPlus";
require("includes/cabecera.php");
if(isset($_POST["usuarioElegido"]) || isset($_POST["idUsuarioValidado"])){
    $idUsuario = isset($_POST["usuarioElegido"]) ? $_POST["usuarioElegido"] : $_POST["idUsuarioValidado"];
    $premioFinalParticipaciones = 0;

    $con = conectar();

    // Obtener el nombre del usuario
    $sqlUsuario = "SELECT * FROM usuarios WHERE idusuario = $idUsuario;";
    $resUsuario = mysqli_query($con, $sqlUsuario) or die(mysqli_error($con));
    $usuario = mysqli_fetch_array($resUsuario);
    $nombreUsuario = $usuario["nomusu"];
    $gananciasIniciales = $usuario["ganancias"];

    $sqlParticipacion = "SELECT * from participaciones where idprop = $idUsuario;";
    $resParticipacion = mysqli_query($con, $sqlParticipacion) or die(mysqli_error($con));
    while ($participacion = mysqli_fetch_array($resParticipacion)) {
        $idSorteo = $participacion["idsorteo"];
        $numeroUsuario = $participacion["numero"];
        $importeUsuario = $participacion["importe"];

        // Obtener los sorteos dentro del rango de fechas
        $sqlSorteo = "SELECT * FROM sorteos WHERE idsorteo = $idSorteo;";
        $resSorteo = mysqli_query($con, $sqlSorteo) or die(mysqli_error($con));

        if ($sorteo = mysqli_fetch_array($resSorteo)) {
            $fechaSorteo = $sorteo["fsorteo"];

            // Obtener el premio correspondiente al sorteo
            $sqlPremio = "SELECT * FROM premios WHERE idsorteo = $idSorteo;";
            $resPremio = mysqli_query($con, $sqlPremio) or die(mysqli_error($con));
            $premio = mysqli_fetch_array($resPremio);

            if ($premio) {
                $numeroPremiado = $premio["numero"];
                $premioSorteo = $premio["premio"];

                // Calcular el premio final
                if($numeroUsuario === $numeroPremiado){
                    $premioFinalParticipaciones += $premioSorteo * $importeUsuario;
                }
            }
        }
    }
    if(mysqli_num_rows($resParticipacion) > 0){
        $premioFinal = $premioFinalParticipaciones + $gananciasIniciales;
    }
}

if(isset($_SESSION["usuarioValidado"])){
?>
<section class="lista">
    <div id="btns-anyadir">
        <?php
        if(isset($_SESSION["usuarioAdmin"])){?>
            <a href="formularioCrearPremio.php" id="btn-anyadir"><img src="images/anyadir.png" id="iconoAnyadir" width="20px" style="position:relative; top:4px">Añadir premio</a>
        <?php
        }
        ?>
    </div>

    <table class="listado">
        <thead>
            <th>Usuario</th>
            <th>Ganancias Iniciales</th>
            <th>Premios acumulados de participaciones</th>
            <th>Premios acumulados totales</th>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $nombreUsuario?></td>
                <td><?php echo number_format($gananciasIniciales, 0, ',', '.')?> €</td>
                <td><?php echo number_format($premioFinalParticipaciones, 0, ',', '.')?> €</td>
                <td><?php echo number_format(isset($premioFinal) ? $premioFinal : $gananciasIniciales, 0, ',', '.')?> €</td>
            </tr>
        </tbody>
    </table>
</section>
<script src="js/cambiarIconoAnyadirGeneral.js"></script>
<?php
}else {?>
    <div class="container-principal">       
        <div class="container-aviso">
            <h1>Debes iniciar sesión para acceder a esta sección</h1>
            <p>Para ver tu información <a href="formularioIniciarSesion.php">inicia sesión</a></p>
            <p>Si no dispones de una cuenta de usuario <a href="index.php">vuelve al inicio</a></p>
        </div>
    </div>
<?php
}
require('includes/pie.php');
?>