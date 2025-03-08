<?php
$titulo = "Crear Sorteo | LotoPlus";
require("includes/cabecera.php");

if(isset($_POST["enviar"])){
    $nsorteo = $_POST["nsorteo"];
    $fsorteo = new DateTime($_POST["fsorteo"]);
    $descrip = $_POST["descrip"];
    $fechaSorteo = $fsorteo->format('Y-m-d');

    $con = conectar();

    $sql = "SELECT * from sorteos where nsorteo = '$nsorteo';";
    $res = mysqli_query($con, $sql) or die(mysqli_error($con));

    if(mysqli_num_rows($res) > 0){
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Ya existe un sorteo con ese nombre',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#19778a',
                    icon: 'error',
                    iconColor: 'red'
                });
            </script>";
        }else{
            $sentencia = mysqli_stmt_init($con);
            $sql = "INSERT into sorteos(nsorteo, fsorteo, descrip) values (?, ?, ?);";
            mysqli_stmt_prepare($sentencia, $sql);
            mysqli_stmt_bind_param($sentencia, 'sss', $nsorteo, $fechaSorteo, $descrip); 
            $res = mysqli_stmt_execute($sentencia) or die(mysqli_error($con));
            mysqli_close($con);
            header("Location: sorteos.php?mensaje=Sorteo creado correctamente&tipoMensaje=success");
            exit;
        }
}

if(isset($_SESSION["usuarioAdmin"])){
?>
<div class="form-container">
    <fieldset id="form-sorteo" style="height: 310px;">
        <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">CREAR SORTEO</span></legend>
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
            <table>
                <tr>
                    <td><input type="text" name="nsorteo" id="nsorteo" placeholder="Nombre del sorteo" required></td>
                    <td colspan="2"><label for="fsorteo">Fecha de sorteo:</label><input type="date" name="fsorteo" id="fsorteo" placeholder="dd/mm/aaaa" required></td>
                </tr>
                <tr>
                    <td colspan="2"><textarea name="descrip" id="descrip" placeholder="Descripción del sorteo..." rows="10" style="margin-bottom: 10px;"></textarea></td>
                </tr>
                <tr>
                    <td><input type="submit" name="enviar" value="CREAR SORTEO"></td>
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
            <h1>Debes iniciar sesión como administrador para acceder a esta sección</h1>
            <p>Para ver tu información <a href="formularioIniciarSesion.php">inicia sesión</a></p>
            <p>Si no dispones de una cuenta de administrador <a href="index.php">vuelve al inicio</a></p>
        </div>
    </div>
<?php
}
require('includes/pie.php');
?>