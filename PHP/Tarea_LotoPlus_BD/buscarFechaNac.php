<?php
$titulo = "Búsqueda por rango de fechas | LotoPlus";
require('includes/cabecera.php');
require('includes/config.php');
if(isset($_SESSION["usuarioAdmin"]) && isset($_POST["fechaNacInicial"]) && isset($_POST["fechaNacFinal"])){
    $fechaNacInicial = $_POST["fechaNacInicial"];
    $fechaNacFinal = $_POST["fechaNacFinal"];
    ?>
    <section>
        <div class="lista">
            <div id="btns-anyadir-usuario">
                <a href="formularioCrearUsuario.php"><img src="images/anyadirUsuario.png" id="iconoAnyadir" width="15px">Añadir usuario</a>
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

            // Total de registros para el rango de fechas
            $sql_count = "SELECT COUNT(*) AS total FROM usuarios WHERE fechanac BETWEEN '$fechaNacInicial' AND '$fechaNacFinal'";
            $result_count = mysqli_query($con, $sql_count) or die(mysqli_error($con));
            $total_registros = mysqli_fetch_assoc($result_count)['total'];

            // Calcular el total de páginas
            $total_pages = ($total_registros > 0) ? ceil($total_registros / $REGISTROS_PAG) : 1;
            mysqli_free_result($result_count);

            // Obtener los registros de la página actual
            if ($total_registros > 0) {
                $sql = "SELECT * FROM usuarios WHERE fechanac BETWEEN '$fechaNacInicial' AND '$fechaNacFinal' GROUP BY idusuario LIMIT $limite, $REGISTROS_PAG";
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
                    echo "<p>No hay usuarios dados de alta en el rango de fechas seleccionado.</p>";
                }
                mysqli_free_result($res);
            } else {
                echo "<p>No hay usuarios en el rango de fechas seleccionado.</p>";
            }
            mysqli_close($con);
            ?>
        </div>
    </section>
    <script src="js/cambiarIconoAnyadirUsuario.js"></script>
    <script src="js/confirmarEliminacion.js"></script>
    <script src="js/formularioBuscar.js"></script>
<?php
}else {
    ?>
        <div class="container-principal">       
            <div class="container-aviso">
                <h1>Debes iniciar sesión como administrador para acceder a esta sección</h1>
                <p>Para acceder <a href="formularioIniciarSesion.php">inicia sesión</a></p>
                <p>Si no dispones de una cuenta de administrador<a href="index.php"> vuelve al inicio</a></p>
            </div>
        </div>
    <?php
}
require('includes/pie.php');
?>
