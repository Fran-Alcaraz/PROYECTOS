<?php
$titulo = "Editar Sorteo | LotoPlus";
require("includes/cabecera.php");

if (isset($_POST["editarSorteo"])) {
    $idsorteo = $_POST["idSorteo"];
    $nsorteo = $_POST["nsorteo"];
    $fsorteo = $_POST["fsorteo"];
    $descrip = $_POST["descrip"];

    $con = conectar();
    $sentencia = mysqli_stmt_init($con);
    $sql = "UPDATE sorteos set nsorteo = ?, fsorteo = ?, descrip = ? where idsorteo = ?;";
    mysqli_stmt_prepare($sentencia, $sql);
    mysqli_stmt_bind_param($sentencia, "sssi", $nsorteo, $fsorteo, $descrip, $idsorteo);
    $res = mysqli_stmt_execute($sentencia) or die(mysqli_error($con));
    mysqli_close($con);
    header("Location: sorteos.php?mensaje=Sorteo actualizado correctamente&tipoMensaje=success");
    exit;
}

if(isset($_SESSION["usuarioAdmin"]) && isset($_POST["editar"])){
    $idsorteo = (int)$_POST["editar"];

    $con = conectar();
    $sql = "SELECT * from sorteos where idsorteo = $idsorteo;";
    $res = mysqli_query($con, $sql) or die(mysqli_error($con));

    $resultados = mysqli_fetch_array($res);

    $nombreSorteo = $resultados["nsorteo"];
    $fechaSorteo = $resultados["fsorteo"];
    $descripcion = $resultados["descrip"];

    mysqli_free_result($res);
    mysqli_close($con);
    ?>
    <div class="form-container">
        <fieldset id="form-sorteo" style="height: 310px;">
            <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">EDITAR SORTEO</span></legend>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <input type="hidden" name="idSorteo" value="<?php echo $idsorteo?>">
                        <td><input type="text" name="nsorteo" id="nsorteo" placeholder="Nombre del sorteo" required value="<?php echo $nombreSorteo ?>"></td>
                        <td colspan="2"><label for="fsorteo">Fecha de sorteo:</label><input type="date" name="fsorteo" id="fsorteo" placeholder="dd/mm/aaaa" required value="<?php echo $fechaSorteo ?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><textarea name="descrip" id="descrip" placeholder="Descripción del sorteo..." rows="10" style="margin-bottom: 10px;"><?php echo $descripcion ?></textarea></td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="editarSorteo" value="ACTUALIZAR SORTEO"></td>
                        <td colspan="2"><input type="reset" value="CANCELAR"></td>
                    </tr>
                </table><br>
            </form>
        </fieldset>
    </div>
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
require("includes/pie.php");
?>