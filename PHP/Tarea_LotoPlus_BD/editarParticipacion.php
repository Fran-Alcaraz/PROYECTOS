<?php
$titulo = "Editar Participación | LotoPlus";
require("includes/cabecera.php");

if(isset($_POST["enviar"])){
    $idpart = $_POST["idpart"];
    $idprop = $_POST["idprop"];
    $idsorteo = $_POST["idsorteo"];
    $numero = $_POST["numero"];
    $importe = $_POST["importe"];
    $rutaFichero = "";

        /*Compruebo que el archivo se haya subido correctamente. Si ya tiene foto y no se quiere cambiar esta se mantiene la anterior sin 
        necesidad de subir de nuevo la que ya tenía el usuario*/
        if (!is_uploaded_file($_FILES['fotoPerfil']['tmp_name'])) {
            $rutaFichero = $_POST["urlFoto"];
        } else if (is_uploaded_file($_FILES['fotoPerfil']['tmp_name'])) {
            /*Si se ha subido correctamente guardamos un nuevo nombre de directorio y, si este no existe, se crea dando 
                    permisos a todos (0777)*/
            $nombreDirectorio = dirname(__FILE__) . '/uploads/';
            if (!is_dir($nombreDirectorio)) {
                mkdir($nombreDirectorio, 0777, true);
            }
            /*Guardo un nombre de fichero completo usando el de directorio que acabo de crear y el nombre real del archivo
                    subido*/
            $nombreFichero = $_FILES['fotoPerfil']['name'];
            $nombreCompletoFichero = $nombreDirectorio . $nombreFichero;

            /*Comprobamos que efectivamente el nombre completo es un fichero y, si lo es, creamos un id único para este y 
                    guardo como nuevo nombre de fichero este id con el nombre original del archivo y lo guardamos junto al
                    directorio como nuevo nombre completo*/
            if (is_file($nombreCompletoFichero)) {
                $idUnico = time();
                $nombreFichero = $idUnico . "-" . $nombreFichero;
                $nombreCompletoFichero = $nombreDirectorio . $nombreFichero;
            }

            //Muevo el archivo a la ruta que hemos indicado y muestro la imagen
            move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $nombreCompletoFichero);
            $rutaFichero = "uploads/".$nombreFichero;
        } else {
            
        }

    $con = conectar();
    $sentencia = mysqli_stmt_init($con);
    $sql = "UPDATE participaciones SET idprop = ?, idsorteo = ?, numero = ?, importe = ?, captura = ? WHERE idpart = ?";
    mysqli_stmt_prepare($sentencia, $sql);
    mysqli_stmt_bind_param($sentencia, "iiidsi", $idprop, $idsorteo, $numero, $importe, $rutaFichero, $idpart);
    $res = mysqli_stmt_execute($sentencia) or die(mysqli_error($con));
    mysqli_close($con);
    header("Location: participaciones.php?mensaje=Participación actualizada correctamente&tipoMensaje=success");
    exit;
}
if(isset($_SESSION["usuarioValidado"]) || isset($_SESSION["usuarioAdmin"])){
    $idpart = $_POST["editar"];
    $con = conectar();
    $sqlEditar = "SELECT * FROM participaciones WHERE idpart = $idpart";
    $resultado = mysqli_query($con, $sqlEditar) or die(mysqli_error($con));

    $fila = mysqli_fetch_array($resultado);

    $idprop = $fila["idprop"];
    $idsorteo = $fila["idsorteo"];
    $numero = $fila["numero"];
    $importe = $fila["importe"];
    $captura = $fila["captura"];

    mysqli_free_result($resultado);
    mysqli_close($con);
    ?>
    <div class="form-container">
        <fieldset style="width: 600px;">
            <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">CREAR PARTICIPACIÓN</span></legend>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idpart" value="<?= $idpart ?>">
                <table>
                    <tr>
                        <td>
                            <label>Nombre del propietario:</label>
                            <select name="idprop" style="width:220px; height:40px;">
                                <?php
                                $con = conectar();
                                $sql = "SELECT idusuario, nombre, apellidos FROM usuarios";
                                $res = mysqli_query($con, $sql) or die(mysqli_error($con));

                                while($fila = mysqli_fetch_array($res)){
                                    $selected = ($fila["idusuario"] == $idprop) ? "selected" : "";
                                    echo "<option value='" . $fila["idusuario"] . "' $selected>" . $fila["nombre"] . " " . $fila["apellidos"] . "</option>";
                                }

                                mysqli_free_result($res);
                                mysqli_close($con);
                                ?>
                            </select>
                        </td>

                        <td>
                        &nbsp;&nbsp;
                        <label>Sorteo:</label>
                            <select name="idsorteo" style="width:100px; height:40px;">
                                <?php
                                $con = conectar();
                                $sql = "SELECT idsorteo, nsorteo FROM sorteos";
                                $res = mysqli_query($con, $sql) or die(mysqli_error($con));

                                while($fila = mysqli_fetch_array($res)){
                                    $selected = ($fila["idsorteo"] == $idsorteo) ? "selected" : "";
                                    echo "<option value='" . $fila["idsorteo"] . "' $selected>" . $fila["nsorteo"] . "</option>";
                                }

                                mysqli_free_result($res);
                                mysqli_close($con);
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Número:</label>
                            <input type="text" name="numero" value="<?= $numero ?>" style="width: 100px; height:20px; margin: 10px 0">
                            &nbsp;
                            <label>Importe:</label>
                            <input type="number" name="importe" value="<?= $importe ?>" style="width: 100px; height:20px;">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label>Imagen de perfil:</label>
                            <input type="hidden" name="urlFoto" value="<?= $captura ?>">
                            <input type="file" name="fotoPerfil" id="fotoPerfil" accept=".jpg, .gif, .png" onchange="validarFichero()" style="width: 300px; height: 20px; border: 1px solid #767676; padding: 10px; margin-bottom: 10px;">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="enviar" id="btn-enviar" value="ACTUALIZAR PARTICIPACIÓN">
                            <input type="reset" value="CANCELAR">
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <script src="js/validarFicheroParticipacion.js"></script>
<?php
}else {?>
    <div class="container-principal">       
        <div class="container-aviso">
            <h1>Debes iniciar sesión para acceder a esta sección</h1>
            <p>Para ver tu información <a href="formularioIniciarSesion.php">inicia sesión</a></p>
            <p>Si no dispones de una cuenta <a href="index.php">vuelve al inicio</a></p>
        </div>
    </div>
<?php
}
require('includes/pie.php');
?>