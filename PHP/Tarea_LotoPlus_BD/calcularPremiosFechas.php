<?php
$titulo = "Cálculo de premios en fechas | LotoPlus";
require("includes/cabecera.php");
$con = conectar();

//Obtengo cuál es la página actual y calculo el límite de páginas a crear
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Asegurarse de que no sea menor que 1
$limite = ($page - 1) * $REGISTROS_PAG;

//Obtengo el total de registros en la base de datos
$sql_count = "SELECT COUNT(*) AS total FROM participaciones";
$result_count = mysqli_query($con, $sql_count) or die(mysqli_error($con));
$total_registros = mysqli_fetch_assoc($result_count)['total'];

//Calculo el total de páginas a mostrar
$total_pages = ceil($total_registros / $REGISTROS_PAG);
mysqli_free_result($result_count);

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
            <th>ID Sorteo</th>
            <th>Fecha Sorteo</th>
            <th>Número premiado</th>
            <th>Premio</th>
            <th>Usuario</th>
            <th>Número participación</th>
            <th>Importe del ganador</th>
            <th>Premio Final</th>
        </thead>
        <tbody>
            <?php
            if (isset($_POST["usuario"]) && isset($_POST["fechaInicial"]) && isset($_POST["fechaFinal"])) {
                $idUsuario = $_POST["usuario"];
                $fechaInicial = $_POST["fechaInicial"];
                $fechaFinal = $_POST["fechaFinal"];
                $totalParticipaciones = 0;

                $con = conectar(); 

                $sqlParticipacion = "SELECT * from participaciones where idprop = $idUsuario LIMIT $limite, $REGISTROS_PAG;";
                $resParticipacion = mysqli_query($con, $sqlParticipacion) or die(mysqli_error($con));
                while ($participacion = mysqli_fetch_array($resParticipacion)) {
                    $idSorteo = $participacion["idsorteo"];
                    $numeroUsuario = $participacion["numero"];
                    $importeUsuario = $participacion["importe"];

                    // Obtener los sorteos dentro del rango de fechas
                    $sqlSorteo = "SELECT * FROM sorteos WHERE fsorteo BETWEEN '$fechaInicial' AND '$fechaFinal' AND idsorteo = $idSorteo;";
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
                                $premioFinal = $premioSorteo * $importeUsuario;
                                // Obtener el nombre del usuario
                                $sqlUsuario = "SELECT * FROM usuarios WHERE idusuario = $idUsuario;";
                                $resUsuario = mysqli_query($con, $sqlUsuario) or die(mysqli_error($con));
                                $usuario = mysqli_fetch_array($resUsuario);
                                $nombreUsuario = $usuario["nomusu"];
                                $totalParticipaciones++;

                                // Imprimir los resultados en la tabla
                                echo "<tr>";
                                echo "<td>" . $idSorteo . "</td>";
                                echo "<td>" . $fechaSorteo . "</td>";
                                echo "<td>" . $numeroPremiado . "</td>";
                                echo "<td>" . number_format($premioSorteo, 0, ',', '.') . " €</td>";
                                echo "<td>" . $nombreUsuario . "</td>";
                                echo "<td>" . $numeroUsuario ."</td>";
                                echo "<td>" . number_format($importeUsuario, 0, ',', '.') . " €</td>";
                                echo "<td>" . number_format($premioFinal, 0, ',', '.') . " €</td>";
                                echo "</tr>";
                            }

                            
                        }
                    }
                }
                echo "<tr>";
                    echo "<td colspan=8>Total de participaciones premiadas del usuario: ".$totalParticipaciones.($totalParticipaciones > 1 || $totalParticipaciones === 0 ? "  participaciones" : " participación")."</td>";
                echo "</tr>";
                mysqli_close($con);
            }
            ?>
        </tbody>
    </table>
    <div class="paginacion">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>" <?= $i == $page ? 'class="activo"' : '' ?> class="indicePaginas"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</section>
<script src="js/cambiarIconoAnyadirGeneral.js"></script>
<?php
}else {?>
    <div class="container-principal">       
        <div class="container-aviso">
            <h1>Debes iniciar sesión como administrador para acceder a esta sección</h1>
            <p>Para ver tu información <a href="formularioIniciarSesion.php">inicia sesión</a></p>
            <p>Si no dispones de una cuenta de administrador <a href="index.php">vuelve al inicio</a></p>
        </div>
    </div>
<?php
}
require('includes/pie.php');
?>