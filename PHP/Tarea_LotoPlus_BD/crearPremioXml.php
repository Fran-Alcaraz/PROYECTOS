<?php
$titulo = "Crear Premio con XML | LotoPlus";
require("includes/cabecera.php");

if (isset($_POST["enviar"])) {

    $rutaFichero = $_FILES["fichero"]["tmp_name"];

    if (file_exists($rutaFichero)) {
        
        $xml = simplexml_load_file($rutaFichero);

        $con = conectar();
        
        $sql = "INSERT INTO premios (idpremio, idsorteo, numero, premio) VALUES (?, ?, ?, ?)";
        $sentencia = mysqli_stmt_init($con);
        
        try {
            mysqli_stmt_prepare($sentencia, $sql);

            foreach ($xml->table as $table) {
                if ((string)$table['name'] == 'premios') {

                    $columns = $table->column;

                    for ($i = 0; $i < count($columns); $i += 4) {
                        $idpremio = (int) $columns[$i];
                        $idsorteo = (int) $columns[$i + 1];
                        $numero = (int) $columns[$i + 2];
                        $importe = (float) $columns[$i + 3];

                        mysqli_stmt_bind_param($sentencia, "iiid", $idpremio, $idsorteo, $numero, $importe);
                        $res = mysqli_stmt_execute($sentencia);
                        
                        if (!$res) {
                            throw new Exception();
                        }
                    }
                }
            }

            mysqli_close($con);

            header("Location: premios.php?mensaje=Premios creados correctamente&tipoMensaje=success");
            exit;

        } catch (Exception $e) {
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'El/Los sorteo/s del fichero no existe/n en la base de datos. Por favor, crealos para insertar el XML.',
                    icon: 'error',
                    confirmButtonColor: '#1f92a9',
                    confirmButtonText: 'Aceptar',
                    iconColor: 'red'
                });
            </script>";
        }

    } else {
        ?>
        <script>
            Swal.fire({
                title: "Error",
                text: "Tienes que seleccionar un archivo XML.",
                icon: "error",
                confirmButtonColor: "#1f92a9",
                confirmButtonText: "Aceptar",
                iconColor: "red"
            });
        </script>
        <?php
    }
}

if (isset($_SESSION["usuarioAdmin"])) {
?>
    <section class="form-container">
        <fieldset style="height: 150px; width: auto;" class="form-premio">
            <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">CREAR PREMIO CON XML</span></legend>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="fichero" id="fichero" style="width: 96%;" accept=".xml" onchange="validarXML()">
                <br><br>
                <input type="submit" value="Subir fichero" name="enviar">
                <input type="reset" value="Cancelar">
            </form>
        </fieldset>
    </section>

    <script src="js/validarFicheroXML.js"></script>
<?php
} else {
?>
    <div class="container-principal">
        <div class="container-aviso">
            <h1>Debes iniciar sesión como administrador para acceder a esta sección</h1>
            <p>Para ver tu información <a href="formularioIniciarSesion.php">inicia sesión</a></p>
            <p>Si no dispones de una cuenta de administrador <a href="index.php">vuelve al inicio</a></p>
        </div>
    </div>
<?php
}

require("includes/pie.php");
?>
