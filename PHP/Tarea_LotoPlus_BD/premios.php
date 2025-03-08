<?php
$titulo = "Listado de premios | LotoPlus";
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
            <button id="btn-anyadir"><img src="images/anyadir.png" id="iconoAnyadir" width="20px" style="position:relative; top:4px;">Añadir premios</button>
            <button type="button" id="btn-calculo-premios-usuario">Calcular premios usuario en intervalo fechas</button>
            <button type="button" id="btn-calculo-premios-acumulados">Calcular premios acumulados de un usuario</button>
        </div>

        <?php
        $con = conectar();

        //Obtengo cuál es la página actual y calculo el límite de páginas a crear
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max($page, 1); // Asegurarse de que no sea menor que 1
        $limite = ($page - 1) * $REGISTROS_PAG;

        //Obtengo el total de registros en la base de datos
        $sql_count = "SELECT COUNT(*) AS total FROM premios";
        $result_count = mysqli_query($con, $sql_count) or die(mysqli_error($con));
        $total_registros = mysqli_fetch_assoc($result_count)['total'];

        //Calculo el total de páginas a mostrar
        $total_pages = ceil($total_registros / $REGISTROS_PAG);
        mysqli_free_result($result_count);

        //Obtengo todos los registros de la página actual
        $sql = "SELECT * FROM premios GROUP BY idpremio LIMIT $limite, $REGISTROS_PAG";
        $res = mysqli_query($con, $sql) or die(mysqli_error($con));

        if (mysqli_num_rows($res) > 0) {
        ?>
            <table class="listado">
                <thead>
                    <th>ID Premio</th>
                    <th>ID Sorteo</th>
                    <th>Número premiado</th>
                    <th>Premio</th>
                    <th colspan="2">Acciones</th>
                </thead>
                <tbody>
                    <?php
                    while ($fila = mysqli_fetch_assoc($res)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($fila["idpremio"]) . "</td>";
                        echo "<td>" . htmlspecialchars($fila["idsorteo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($fila["numero"]) . "</td>";
                        echo "<td>" . htmlspecialchars(number_format($fila["premio"], 0, ',', '.')) . " €</td>";
                        echo "<td><form action='editarPremio.php' method='post'>
                        <input type='hidden' name='editar' value='" . htmlspecialchars($fila["idpremio"]) . "'>
                        <input type='submit' value='Editar' id='editar'></form></td>";
                        echo "<td><form action='eliminarPremio.php' method='post' onsubmit='return confirmarEliminacion(event, this);'>
                        <input type='hidden' name='eliminar' value='" . htmlspecialchars($fila["idpremio"]) . "'>
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
            echo "<p>No hay premios actualmente</p>";
        }
        ?>
    </div>
</section>

<script src="js/cambiarIconoAnyadirGeneral.js"></script>
<script src="js/confirmarEliminacion.js"></script>
<script>
    document.getElementById("btn-anyadir").addEventListener("click", function(){
        Swal.fire({
            title: "Elija una opción",
            html: `
                <div class='tabla-btns-premios'>
                    <table class='opciones-crear-premios'>
                        <tr>
                            <td><a href='formularioCrearPremio.php'>Añadir premio manualmente</a></td>
                        </tr>
                        <tr>
                            <td><a href='crearPremioXml.php'>Añadir premio con fichero XML</a></td>
                        </tr>
                    </table>
                </div>
            `,
            showConfirmButton: false,
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#ca0505",
            customClass: {
                popup: "btns-crear-premios"
            }
        });
    });

    document.getElementById("btn-calculo-premios-usuario").addEventListener("click", function() {
        Swal.fire({
            title: "Calcular premio del usuario en intervalo de fechas",
            html: `
                <form action='calcularPremiosFechas.php' method='post' class='form-buscar-usuario' id='formulario-premios-fechas'>
                    <table style='text-align: left;'>
                        <tr>
                            <td><label for='usuario'>Usuario:</label></td>
                            <td><select name='usuario' id='usuario' class='select-usuario'>
                                <?php
                                $con = conectar();
                                $sql = "SELECT idusuario, nombre, apellidos FROM usuarios";
                                $res = mysqli_query($con, $sql) or die(mysqli_error($con));

                                while ($fila = mysqli_fetch_array($res)) {
                                    echo "<option value='" . $fila["idusuario"] . "'>" . $fila["nombre"] . " " . $fila["apellidos"] . "</option>";
                                }
                                mysqli_free_result($res);
                                mysqli_close($con);
                                ?>
                            </select></td>
                        </tr>
                        <tr>
                            <td><label for='fechaInicial'>Fecha inicial:</label></td>
                            <td><input type='date' name='fechaInicial' id='fechaInicial' placeholder='dd/mm/yyyy' required></td>
                        </tr>
                        <tr>
                            <td><label for='fechaFinal'>Fecha final:</label></td>
                            <td><input type='date' name='fechaFinal' id='fechaFinal' placeholder='dd/mm/yyyy' required></td>
                        </tr>
                    </table>
                </form>
            `,
            confirmButtonText: "Calcular premios",
            confirmButtonColor: "#19778a",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#ca0505"
        }).then((resultado) => {
            if(resultado.isConfirmed){
                const form = document.getElementById("formulario-premios-fechas");
                form.submit();
            }
        });
    });

    document.getElementById("btn-calculo-premios-acumulados").addEventListener("click", function(){
        Swal.fire({
            title: "Calcular premios acumulados de un usuario",
            html: `
                <form action='calcularPremiosAcumulados.php' method='post' class='form-premios-acumulados' id='form-premios-acumulados'>
                    <select name='usuarioElegido' id='usuarioElegido'>
                    <?php
                    $con = conectar();
                    $sql = "SELECT * from usuarios group by nombre;";
                    $res = mysqli_query($con, $sql) or die(mysqli_error($con));

                    while($fila = mysqli_fetch_array($res)){
                        echo "<option value='".$fila["idusuario"]."'>".$fila["nomusu"]."</option>";
                    }
                    ?>
                    </select>
                </form>
            `,
            confirmButtonText: "Calcular",
            confirmButtonColor: "#19778a",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#ca0505"
        }).then((resultado) => {
            if(resultado.isConfirmed){
                const form = document.getElementById("form-premios-acumulados");
                form.submit();
            }
        });
    });
</script>
<?php
}else if(isset($_SESSION["usuarioValidado"])){
?>
<section class="container-principal">
    <div class="container-btns-premios">
        <h1>Elige la acción que deseas realizar</h1>
        <button type="button" id="btn-calculo-premios-usuario" style="font-size: 20px;">Calcular premios en intervalo de fechas</button>
        <button type="button" id="btn-calculo-premios-acumulados" style="font-size: 20px;">Calcular premios acumulados</button>
    </div>
</section>

<script>
    <?php
    function obtenerIdUsuario(){
        $nombreUsuario = $_SESSION["usuarioValidado"];
        $con = conectar();
        $sql = "SELECT * from usuarios where nomusu = '$nombreUsuario';";
        $res = mysqli_query($con, $sql) or die(mysqli_error($con));
        $resultado = mysqli_fetch_array($res);
        $idUsuario = $resultado["idusuario"];
        return $idUsuario;
    }
    ?>
    document.getElementById("btn-calculo-premios-usuario").addEventListener("click", function() {
        Swal.fire({
            title: "Calcular premio del usuario en intervalo de fechas",
            html: `
                <form action='calcularPremiosFechas.php' method='post' class='form-buscar-usuario' id='formulario-premios-fechas'>
                    <table style='text-align: left;'>
                        <tr>
                            <?php
                            $idUsuario = obtenerIdUsuario();
                            echo "<td><input type='hidden' name='usuario' id='usuario' value='".$idUsuario."'></td>";
                            ?>
                        </tr>
                        <tr>
                            <td><label for='fechaInicial'>Fecha inicial:</label></td>
                            <td><input type='date' name='fechaInicial' id='fechaInicial' placeholder='dd/mm/yyyy' required></td>
                        </tr>
                        <tr>
                            <td><label for='fechaFinal'>Fecha final:</label></td>
                            <td><input type='date' name='fechaFinal' id='fechaFinal' placeholder='dd/mm/yyyy' required></td>
                        </tr>
                    </table>
                </form>
            `,
            confirmButtonText: "Calcular premios",
            confirmButtonColor: "#19778a",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#ca0505"
        }).then((resultado) => {
            if(resultado.isConfirmed){
                const form = document.getElementById("formulario-premios-fechas");
                form.submit();
            }
        });
    });

    document.getElementById("btn-calculo-premios-acumulados").addEventListener("click", function(){
        Swal.fire({
            title: "Calcular premios acumulados del usuario",
            html: `
                <form action='calcularPremiosAcumulados.php' method='post' class='form-premios-acumulados' id='form-premios-acumulados'>
                    <?php
                    $idUsuario = obtenerIdUsuario();
                    echo "<td><input type='hidden' name='idUsuarioValidado' id='idUsuarioValidado' value='".$idUsuario."'></td>";
                    ?>
                </form>
            `,
            confirmButtonText: "Calcular",
            confirmButtonColor: "#19778a",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#ca0505"
        }).then((resultado) => {
            if(resultado.isConfirmed){
                const form = document.getElementById("form-premios-acumulados");
                form.submit();
            }
        });
    });
</script>
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