<?php
$titulo = "Cambiar contraseña | LotoPlus";
require("includes/cabecera.php");

if(isset($_POST["cambiar"])){
    $nombreUsuario = $_SESSION["usuarioValidado"];
    $nuevaContrasenya = htmlspecialchars($_POST["nuevaContrasenya"]);
    $repiteNuevaContrasenya = htmlspecialchars($_POST["repiteNuevaContrasenya"]);

    if($repiteNuevaContrasenya !== $nuevaContrasenya){
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Las contraseñas no coinciden',
                icon: 'error',
                iconColor: 'red',
                confirmButtonColor: '#19778a',
                confirmButtonText: 'Aceptar'
            });
        </script>";
    }else {
        $con = conectar();
        $sql = "SELECT * from usuarios where nomusu = '$nombreUsuario';";
        $res = mysqli_query($con, $sql) or die(mysqli_error($con));
        $resultado = mysqli_fetch_array($res);
        $idUsuario = $resultado["idusuario"];

        if(password_verify($nuevaContrasenya, $resultado["clave"])){
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'La nueva contraseña coincide con la anterior.',
                    icon: 'error',
                    iconColor: 'red',
                    confirmButtonColor: '#19778a',
                    confirmButtonText: 'Aceptar'
                });
            </script>";
        }else {
            $sentencia = mysqli_stmt_init($con);
            $nuevaContrasenyaCifrada = password_hash($nuevaContrasenya, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET clave = ? where idusuario = ?;";
            mysqli_stmt_prepare($sentencia, $sql);
            mysqli_stmt_bind_param($sentencia, "si", $nuevaContrasenyaCifrada, $idUsuario);
            $res = mysqli_stmt_execute($sentencia) or die(mysqli_error($con));
            mysqli_close($con);
            header("Location: index.php?titulo=Éxito&mensaje=Contraseña actualizada correctamente&tipoMensaje=success&colorIcono=ForestGreen");
            exit;
        }
    }
}

if(isset($_SESSION["usuarioValidado"]) || isset($_SESSION["usuarioAdmin"])){
?>
<div class="form-container">
    <fieldset style="width: auto; height: auto;">
        <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">CAMBIAR CONTRASEÑA</span></legend>
        <form action="<?=$_SERVER["PHP_SELF"]?>" method="post" id="form-cambiar-contrasenya">
            <table>
                <tr>
                    <td><input type="password" name="nuevaContrasenya" id="nuevaContrasenya" placeholder="Introduce tu nueva contraseña..."></td>
                </tr>
                <tr style="height: 20px;"></tr>
                <tr>
                    <td><input type="password" name="repiteNuevaContrasenya" id="repiteNuevaContrasenya" placeholder="Repite tu nueva contraseña..."></td>
                </tr>
                <tr style="height: 20px;"></tr>
                <tr>
                    <td><input type="submit" value="Cambiar contraseña" name="cambiar"></td>
                </tr>
                <tr>
                    <td><input type="reset" value="Cancelar" style="border-radius: 5px;"></td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
<?php
}else {?>
    <div class="container-principal">       
        <div class="container-aviso">
            <h1>Debes iniciar sesión como usuario o administrador para acceder a esta sección</h1>
            <p>Para ver tu información <a href="formularioIniciarSesion.php">inicia sesión</a></p>
            <p>Si no dispones de una cuenta de usuario o administrador <a href="index.php">vuelve al inicio</a></p>
        </div>
    </div>
<?php
}
require("includes/pie.php");
?>