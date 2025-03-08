<?php
$titulo = "Listado de participaciones | LotoPlus";
require('includes/cabecera.php');
require('includes/config.php');

if (isset($_GET["mensaje"]) && isset($_GET["tipoMensaje"]) && !isset($_GET["tituloMensaje"]) && !isset($_GET["iconColor"])) {
    $mensaje = htmlspecialchars($_GET["mensaje"], ENT_QUOTES, "UTF-8");
    $tipoMensaje = htmlspecialchars($_GET["tipoMensaje"], ENT_QUOTES, "UTF-8");
    echo "<script>
            Swal.fire({
                title: 'Éxito',
                text: '$mensaje',
                icon: '$tipoMensaje',
                iconColor: 'ForestGreen',
                confirmButtonText: 'Aceptar',
                customClass:{
                    confirmButton: 'btn-crear'
                }
            }).then(()=>{
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        </script>";
}

$administrador = isset($_SESSION["usuarioAdmin"]) ? $_SESSION["usuarioAdmin"] : "";
if(isset($_SESSION["usuarioValidado"]) || isset($_SESSION["usuarioAdmin"])){
?>
<section>
    <div class="lista">
            <div id="btns-anyadir">
                <a href="formularioCrearParticipacion.php" id="btn-anyadir"><img src="images/anyadir.png" id="iconoAnyadir" width="20px" style="position:relative; top:4px">Añadir participación</a>
            </div>
        <?php
        $con = conectar();

        if($administrador){
            //Obtengo cuál es la página actual y calculo el límite de páginas a crear
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $page = max($page, 1); // Asegurarse de que no sea menor que 1
            $limite = ($page - 1) * $REGISTROS_PAG;

            //Obtengo el total de registros en la base de datos
            $sql_count = "SELECT COUNT(*) AS total FROM participaciones;";
            $result_count = mysqli_query($con, $sql_count) or die(mysqli_error($con));
            $total_registros = mysqli_fetch_assoc($result_count)['total'];

            //Calculo el total de páginas a mostrar
            $total_pages = ceil($total_registros / $REGISTROS_PAG);
            mysqli_free_result($result_count);

            //Obtengo todos los registros de la página actual
            $sql = "SELECT * FROM participaciones GROUP BY idpart LIMIT $limite, $REGISTROS_PAG";
            $res = mysqli_query($con, $sql) or die(mysqli_error($con));
        }else if(isset($_SESSION["usuarioValidado"])){
            $nombreUsuario = $_SESSION["usuarioValidado"];
            $sql = "SELECT * from usuarios where nomusu = '$nombreUsuario';";
            $res = mysqli_query($con, $sql) or die(mysqli_error($con));
            $resultado = mysqli_fetch_array($res);
            $idUsuario = $resultado["idusuario"];

            //Obtengo cuál es la página actual y calculo el límite de páginas a crear
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $page = max($page, 1); // Asegurarse de que no sea menor que 1
            $limite = ($page - 1) * $REGISTROS_PAG;

            //Obtengo el total de registros en la base de datos
            $sql_count = "SELECT COUNT(*) AS total FROM participaciones where idprop = $idUsuario";
            $result_count = mysqli_query($con, $sql_count) or die(mysqli_error($con));
            $total_registros = mysqli_fetch_assoc($result_count)['total'];

            //Calculo el total de páginas a mostrar
            $total_pages = ceil($total_registros / $REGISTROS_PAG);
            mysqli_free_result($result_count);

            //Obtengo todos los registros de la página actual
            $sql = "SELECT * FROM participaciones where idprop = $idUsuario GROUP BY idpart LIMIT $limite, $REGISTROS_PAG";
            $res = mysqli_query($con, $sql) or die(mysqli_error($con));
        }

        if (mysqli_num_rows($res) > 0) {
        ?>
            <table class="listado">
                <thead>
                    <th>ID Participación</th>
                    <th>ID Propietario</th>
                    <th>ID Sorteo</th>
                    <th>Numero</th>
                    <th>Importe</th>
                    <th>Captura</th>
                    <th colspan="2">Acciones</th>
                </thead>
                <tbody>
                    <?php
                    while ($fila = mysqli_fetch_assoc($res)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($fila["idpart"]) . "</td>";
                        echo "<td>" . htmlspecialchars($fila["idprop"]) . "</td>";
                        echo "<td>" . htmlspecialchars($fila["idsorteo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($fila["numero"]) . "</td>";
                        echo "<td>" . htmlspecialchars(number_format($fila["importe"], 0, ',', '.')) . " €</td>";
                        echo "<td>" . ($fila["captura"] ? "<img src='" . htmlspecialchars($fila["captura"]) . "' width='60px'>" : "Sin captura") . "</td>";
                        echo "<td><form action='editarParticipacion.php' method='post'>
                            <input type='hidden' name='editar' value='" . htmlspecialchars($fila["idpart"]) . "'>
                            <input type='submit' value='Editar' id='editar'></form></td>";
                        echo "<td><form action='eliminarParticipacion.php' method='post' onsubmit='return confirmarEliminacion(event, this);'>
                            <input type='hidden' name='eliminar' value='" . htmlspecialchars($fila["idpart"]) . "'>
                            <input type='submit' value='Eliminar' id='eliminar'></form></td>";
                        echo "</tr>";
                    }
                    mysqli_free_result($res);
                    mysqli_close($con);
                    ?>
                </tbody>
            </table>

            <!-- Navegación de paginación -->
            <div class="paginacion">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?= $i ?>" <?= $i == $page ? 'class="activo"' : '' ?> class="indicePaginas"><?= $i ?></a>
                <?php endfor; ?>
            </div>
        <?php
        } else {
            echo "<p>No hay participaciones actualmente</p>";
        }
        ?>
    </div>
</section>
<script src="js/cambiarIconoAnyadirGeneral.js"></script>
<script src="js/confirmarEliminacion.js"></script>
<?php
}else {?>
    <div class="container-principal">       
        <div class="container-aviso">
            <h1>Debes iniciar sesión como usuario o administrador para acceder a esta sección</h1>
            <p>Para acceder <a href="formularioIniciarSesion.php">inicia sesión</a></p>
            <p>Si no dispones de una cuenta de administrador o usuario<a href="index.php"> vuelve al inicio</a></p>
        </div>
    </div>
<?php
}
require('includes/pie.php');
?>