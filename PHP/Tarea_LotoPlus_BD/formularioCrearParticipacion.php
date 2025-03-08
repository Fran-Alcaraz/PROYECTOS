<?php
$titulo = "Crear Participación | LotoPlus";
require("includes/cabecera.php");

if(isset($_POST["enviar"])){
    $idusuario = $_POST["idpropietario"];
    if(isset($_POST["idsorteo"])){
    $idsorteo = $_POST["idsorteo"];
    }
    $numero = $_POST["numero"];
    $importe = $_POST["importe"];
    $rutaFichero = "";

    if (!is_uploaded_file($_FILES['fotoPerfil']['tmp_name'])) {
        
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
        $rutaFichero = "uploads/" . $nombreFichero;
    } else {
        
    }

    $con = conectar();
    mysqli_report(MYSQLI_REPORT_OFF);
    $sentencia = mysqli_stmt_init($con);
    $sql = "SELECT * from participaciones where (idsorteo = ?) and (numero = ?);";
    mysqli_stmt_prepare($sentencia, $sql);
    mysqli_stmt_bind_param($sentencia, "ii", $idsorteo, $numero);
    mysqli_stmt_execute($sentencia);
    $res = mysqli_stmt_get_result($sentencia);

    if(!isset($idsorteo)){
        ?>
        <script>
            Swal.fire({
                title: "Error",
                text: "No existe ningún sorteo para jugar.",
                icon: "error",
                confirmButtonColor: "#1f92a9",
                confirmButtonText: "Aceptar",
                iconColor: "red"
            });
        </script>
        <?php
    }else{

    if(mysqli_num_rows($res) > 0){
        ?>
        <script>
            Swal.fire({
                title: "Error",
                text: "El número elegido ya está en uso en ese sorteo.",
                icon: "error",
                confirmButtonColor: "#1f92a9",
                confirmButtonText: "Aceptar",
                iconColor: "red"
            });
        </script>
        <?php
        mysqli_close($con);
    }else {
        $sentencia = mysqli_stmt_init($con);
        $sql = "INSERT INTO participaciones (idprop, idsorteo, numero, importe, captura) VALUES (?, ?, ?, ?, ?)";
        mysqli_stmt_prepare($sentencia, $sql);
        mysqli_stmt_bind_param($sentencia, "iiids", $idusuario, $idsorteo, $numero, $importe, $rutaFichero);
        $res = mysqli_stmt_execute($sentencia) or die(mysqli_error($con));
        mysqli_close($con);
        header("Location: participaciones.php?mensaje=Participación creada correctamente&tipoMensaje=success");
        exit;
    }
    }
}

if(isset($_SESSION["usuarioValidado"])){
?>
<div class="form-container">
    <fieldset style="width: 600px;">
        <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">CREAR PARTICIPACIÓN</span></legend>
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
                        <?php
                        $nombreUsuario = $_SESSION["usuarioValidado"];
                        $con = conectar();
                        $sql = "SELECT idusuario, nombre, apellidos FROM usuarios WHERE nomusu = '$nombreUsuario'";
                        $res = mysqli_query($con, $sql) or die(mysqli_error($con));
                        $fila = mysqli_fetch_array($res);
                        $idusuario = $fila["idusuario"];
                        $nombreCompleto = $fila["nombre"] . " " . $fila["apellidos"];
                        ?>
                        <label>Nombre del propietario:</label>
                        <input type="text" value="<?php echo $nombreCompleto ?>" style="width: 178px; height: 20px;" readonly>
                        <input type="hidden" name="idpropietario" value="<?php echo $idusuario ?>">
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
                                echo "<option value='" . $fila["idsorteo"] . "'>" . $fila["nsorteo"] . "</option>";
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
                        <input type="text" name="numero" style="width: 100px; height:20px; margin: 10px 0" required>
                        &nbsp;
                        <label>Importe:</label>
                        <input type="number" name="importe" style="width: 100px; height:20px;" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Captura:</label>
                        <input type="file" name="fotoPerfil" id="fotoPerfil" accept=".jpg, .gif, .png" onchange="validarFichero()" style="width: 300px; height: 20px; border: 1px solid #767676; padding: 10px; margin-bottom: 10px;">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="enviar" id="btn-enviar" value="CREAR PARTICIPACIÓN">
                        <input type="reset" value="CANCELAR">
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
<?php
} else if(isset($_SESSION["usuarioAdmin"])){
?>
    <div class="form-container">
    <fieldset style="width: 600px;">
        <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">CREAR PARTICIPACIÓN</span></legend>
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
                        <label>Nombre del propietario:</label>
                        <select name="idpropietario" style="width:220px; height:40px;">
                            <?php
                            $con = conectar();
                            $sql = "SELECT idusuario, nombre, apellidos FROM usuarios";
                            $res = mysqli_query($con, $sql) or die(mysqli_error($con));

                            while($fila = mysqli_fetch_array($res)){
                                echo "<option value='" . $fila["idusuario"] . "'>" . $fila["nombre"] . " " . $fila["apellidos"] . "</option>";
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
                                echo "<option value='" . $fila["idsorteo"] . "'>" . $fila["nsorteo"] . "</option>";
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
                        <input type="text" name="numero" style="width: 100px; height:20px; margin: 10px 0" required>
                        &nbsp;
                        <label>Importe:</label>
                        <input type="number" name="importe" style="width: 100px; height:20px;" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label>Captura:</label>
                        <input type="file" name="fotoPerfil" id="fotoPerfil" accept=".jpg, .gif, .png" onchange="validarFichero()" style="width: 300px; height: 20px; border: 1px solid #767676; padding: 10px; margin-bottom: 10px;">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="enviar" id="btn-enviar" value="CREAR PARTICIPACIÓN">
                        <input type="reset" value="CANCELAR">
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
<?php
} else {?>
    <div class="container-principal">       
        <div class="container-aviso">
            <h1>Debes iniciar sesión para acceder a esta sección</h1>
            <p>Para acceder <a href="formularioIniciarSesion.php">inicia sesión</a></p>
            <p>Si no dispones de una cuenta de usuario<a href="formularioCrearUsuario.php"> puedes crearla</a></p>
        </div>
    </div>
<?php
}
?>
<script src="js/validarFicheroParticipacion.js"></script>
<?php
require('includes/pie.php');
?>