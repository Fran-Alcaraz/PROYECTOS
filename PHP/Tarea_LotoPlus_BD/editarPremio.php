<?php
$titulo = "Editar Premio | LotoPlus";
require("includes/cabecera.php");

if(isset($_POST["enviar"])){
    $idPremio = $_POST["idPremio"];
    $idsorteo = $_POST["idsorteo"];
    $numPremiado = $_POST["numPremiado"];
    $premio = $_POST["premio"];

    $con = conectar();
    
    $sqlIdSorteo = "SELECT * from sorteos where idsorteo = $idsorteo;";
    $res = mysqli_query($con, $sqlIdSorteo) or die(mysqli_error($con));

    if(mysqli_num_rows($res) > 0){
        $sentencia = mysqli_stmt_init($con);
        $sql = "UPDATE premios set idsorteo = ?, numero = ?, premio = ? where idpremio = ?;";
        mysqli_stmt_prepare($sentencia, $sql);
        mysqli_stmt_bind_param($sentencia, 'iidi', $idsorteo, $numPremiado, $premio, $idPremio); 
        $res = mysqli_stmt_execute($sentencia) or die(mysqli_error($con));
        mysqli_close($con);
        header("Location: premios.php?mensaje=Premio actualizado correctamente&tipoMensaje=success");
        exit;
    }else {
        header("Location: premios.php?tituloMensaje=Error al actualizar&mensaje=El sorteo con el ID introducido no existe&tipoMensaje=error&iconColor=#e10303");
    }
}

if(isset($_SESSION["usuarioAdmin"])){
    $idPremio = (int)$_POST["editar"];
    $con = conectar();
    $sql = "SELECT * from premios where idpremio = $idPremio;";
    $res = mysqli_query($con, $sql) or die(mysqli_error($con));
    $resultado = mysqli_fetch_array($res);

    $idSorteo = $resultado["idsorteo"];
    $numeroPremiado = $resultado["numero"];
    $premio = $resultado["premio"];
    ?>
    <div class="form-container">
        <fieldset id="form-premio" style="height: 190px;">
            <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">EDITAR PREMIO</span></legend>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                <table>
                    <tr>
                        <td><select name="idsorteo" id="idsorteo">
                            <?php
                                $con = conectar();
                                $sql = "SELECT * from sorteos;";
                                $res = mysqli_query($con, $sql) or die(mysqli_error($con));

                                while($fila = mysqli_fetch_row($res)){
                                    echo "<option value='" . $fila[0] . "'";
                                    echo $fila[0] === $idSorteo ? " selected" : ""; // Añade "selected" si coincide con $idSorteo
                                    echo ">" . $fila[1] . "</option>";                            }
                            ?>
                        </select></td>
                        <td colspan="2"><input type="number" name="numPremiado" id="numPremiado" placeholder="Número premiado" required 
                        value="<?php echo $numeroPremiado?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="number" name="premio" id="premio" placeholder="Premio" value="<?php echo $premio?>" style="margin-bottom: 10px;"></td>
                    </tr>
                    <tr>
                        <input type="hidden" name="idPremio" value="<?php echo $idPremio?>">
                        <td><input type="submit" name="enviar" value="ACTUALIZAR PREMIO"></td>
                        <td colspan="4"><input type="reset" value="CANCELAR"></td>
                    </tr>
                </table><br>
            </form>
        </fieldset>
    </div>
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