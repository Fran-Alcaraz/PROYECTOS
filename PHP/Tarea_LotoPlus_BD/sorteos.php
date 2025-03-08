<?php
$titulo = "Listado de sorteos | LotoPlus";
require('includes/cabecera.php');
require('includes/config.php'); // Donde se define $REGISTROS_PAG

if (isset($_GET["mensaje"]) && isset($_GET["tipoMensaje"])) {
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

if(isset($_SESSION["usuarioAdmin"])){
?>
<section>
    <div class="lista">
        <div id="btns-anyadir">
            <a href="formularioCrearSorteo.php" id="btn-anyadir"><img src="images/anyadir.png" id="iconoAnyadir" width="20px" style="position:relative; top:4px">Añadir sorteo</a>
        </div>

        <?php
        $con = conectar();

        // Página actual y cálculo del offset
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max($page, 1); // Asegurarse de que no sea menor que 1
        $limite = ($page - 1) * $REGISTROS_PAG;

        // Total de registros
        $sql_count = "SELECT COUNT(*) AS total FROM sorteos";
        $result_count = mysqli_query($con, $sql_count) or die(mysqli_error($con));
        $total_registros = mysqli_fetch_assoc($result_count)['total'];

        // Calcular el total de páginas
        $total_pages = ceil($total_registros / $REGISTROS_PAG);
        mysqli_free_result($result_count);

        // Obtener los registros de la página actual
        $sql = "SELECT * FROM sorteos GROUP BY idsorteo LIMIT $limite, $REGISTROS_PAG";
        $res = mysqli_query($con, $sql) or die(mysqli_error($con));

        if (mysqli_num_rows($res) > 0) {
        ?>
            <table class="listado">
                <thead>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Fecha de sorteo</th>
                    <th>Descripción</th>
                    <th colspan="2">Acciones</th>
                </thead>
                <tbody>
                    <?php
                    while ($fila = mysqli_fetch_assoc($res)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($fila["idsorteo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($fila["nsorteo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($fila["fsorteo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($fila["descrip"]) . "</td>";
                        echo "<td><form action='editarSorteo.php' method='post'>
                        <input type='hidden' name='editar' value='" . htmlspecialchars($fila["idsorteo"]) . "'>
                        <input type='submit' value='Editar' id='editar'></form></td>";
                        echo "<td><form action='eliminarSorteo.php' method='post' onsubmit='return confirmarEliminacion(event, this);'>
                        <input type='hidden' name='eliminar' value='" . htmlspecialchars($fila["idsorteo"]) . "'>
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
            echo "<p>No hay sorteos actualmente</p>";
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
            <h1>Debes iniciar sesión como administrador para acceder a esta sección</h1>
            <p>Para ver tu información <a href="formularioIniciarSesion.php">inicia sesión</a></p>
            <p>Si no dispones de una cuenta de administrador <a href="index.php">vuelve al inicio</a></p>
        </div>
    </div>
<?php
}
require('includes/pie.php');
?>
