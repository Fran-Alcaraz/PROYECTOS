<?php
$titulo = "Listado de usuarios | LotoPlus";
require('includes/cabecera.php');

if(isset($_GET["mensaje"]) && isset($_GET["tipoMensaje"]) && isset($_GET["titulo"]) && isset($_GET["colorIcono"])){
    $mensaje = htmlspecialchars($_GET["mensaje"], ENT_QUOTES, "UTF-8");
    $titulo = htmlspecialchars($_GET["titulo"], ENT_QUOTES, "UTF-8");
    $tipoMensaje = htmlspecialchars($_GET["tipoMensaje"], ENT_QUOTES, "UTF-8");
    $colorIcono = htmlspecialchars($_GET["colorIcono"], ENT_QUOTES, "UTF-8");
    echo "<script>
            Swal.fire({
                title: '$titulo',
                text: '$mensaje',
                icon: '$tipoMensaje',
                iconColor: '$colorIcono',
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
    <div class="lista">
        <div id="btns-anyadir-usuario">
            <a href="formularioCrearUsuario.php" id="btn-anyadir-usuario"><img src="images/anyadirUsuario.png" id="iconoAnyadir" width="15px">Añadir usuario</a>
            <button type="button" id="btn-nombre-real">Buscar usuario por nombre real</button>
            <button type="button" id="btn-nombre-usuario">Buscar usuario por nombre de usuario</button>
            <button type="button" id="btn-fecha-nac">Buscar usuario por rango fechas nacimiento</button>
        </div>
        <?php
        $con = conectar();

        // Página actual y cálculo del offset
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max($page, 1); // Asegurarse de que no sea menor que 1
        $limite = ($page - 1) * $REGISTROS_PAG;

        // Total de registros
        $sql_count = "SELECT COUNT(*) AS total FROM usuarios";
        $result_count = mysqli_query($con, $sql_count) or die(mysqli_error($con));
        $total_registros = mysqli_fetch_assoc($result_count)['total'];

        // Calcular el total de páginas
        $total_pages = ceil($total_registros / $REGISTROS_PAG);
        mysqli_free_result($result_count);

        // Obtener los registros de la página actual
        $sql = "SELECT * FROM usuarios GROUP BY idusuario LIMIT $limite, $REGISTROS_PAG";
        $res = mysqli_query($con, $sql) or die(mysqli_error($con));

        if (mysqli_num_rows($res) > 0) {
        ?>
            <table class="listado">
                <thead>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Nombre de usuario</th>
                    <th>Clave</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Ganancias</th>
                    <th>Fecha Nac.</th>
                    <th>Foto</th>
                    <th>Tipo de cuenta</th>
                    <th>Marketing</th>
                    <th>Tipo de usuario</th>
                    <th colspan="2">Acciones</th>
                </thead>
                <tbody>
                    <?php
                    while ($fila = mysqli_fetch_array($res)) {
                        echo "<tr>";
                        echo "<td>" . $fila["idusuario"] . "</td>";
                        echo "<td>" . $fila["nombre"] . "</td>";
                        echo "<td>" . $fila["apellidos"] . "</td>";
                        echo "<td>" . $fila["nomusu"] . "</td>";
                        echo "<td class='limit-text'>" . $fila["clave"] . "</td>";
                        echo "<td class='wrap-text'>" . $fila["email"] . "</td>";
                        echo "<td>" . $fila["tel"] . "</td>";
                        echo "<td>" . number_format($fila["ganancias"], 0, ',', '.') . " €</td>";
                        echo "<td>" . $fila["fechanac"] . "</td>";
                        echo "<td>" . ($fila["imgusu"] ? "<img src='" . htmlspecialchars($fila["imgusu"]) . "' width='60px'>" : "Sin captura") . "</td>";
                        echo "<td>" . $fila["tipocu"] . "</td>";
                        echo "<td>" . $fila["marketing"] . "</td>";
                        echo "<td>" . $fila["tipousu"] . "</td>";
                        echo "<td><form action='editarUsuario.php' method='post'>
                        <input type='hidden' name='editar' value='".$fila["idusuario"]."'>
                        <input type='submit' value='Editar' id='editar'></form></td>";
                        echo "<td><form action='eliminarUsuario.php' method='post' onsubmit='return confirmarEliminacion(event, this);'>
                        <input type='hidden' name='eliminar' value='".$fila["idusuario"]."'>
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
            echo "<p>No hay usuarios dados de alta</p>";
        }
        ?>
    </div>

<script src="js/cambiarIconoAnyadirUsuario.js"></script>
<script src="js/confirmarEliminacion.js"></script>
<script src="js/formularioBuscar.js"></script>
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