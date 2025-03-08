<?php
$titulo = "Iniciar sesión | LotoPlus";
require("includes/cabecera.php");
if(isset($_POST["enviar"])){
    $nombreUsuario = $_POST["nomUsuario"];
    $contrasenya = $_POST["contrasenya"];

    $con = conectar();
    $sentencia = mysqli_stmt_init($con);
    $sql = "SELECT * from usuarios where nomusu = ?;";
    mysqli_stmt_prepare($sentencia, $sql);
    mysqli_stmt_bind_param($sentencia, "s", $nombreUsuario);
    $res = mysqli_stmt_execute($sentencia) or die(mysqli_error($con));
    $resultado = mysqli_stmt_get_result($sentencia);
    $fila = mysqli_fetch_array($resultado);
    $claveUsuario = isset($fila) ? $fila["clave"] : "";

    if(password_verify($contrasenya, $claveUsuario)){
        header("Location: index.php");
        if($fila["tipousu"] === "n"){
            $_SESSION["usuarioValidado"] = $nombreUsuario;
        }else{
            $_SESSION["usuarioAdmin"] = $nombreUsuario;
        }
    }else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                icon: 'error',
                text: 'El nombre de usuario y/o contraseña introducidos no son válidos',
                iconColor: '#e10303',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#1f92a9'
            }).then(()=>{
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        </script>";
    }
    mysqli_close($con);
}
?>
<div class="form-container">
    <fieldset style="width: auto; height: auto">
        <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">INICIAR SESIÓN</span><span id="titulo">(o <a href="formularioCrearUsuario.php">crea tu cuenta de usuario</a>)</span></legend>
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
            <table>
                <tr>
                    <td><label for="nomUsuario">Nombre de usuario:</label></td>
                    <td><input type="text" name="nomUsuario" id="nomUsuario" placeholder="Introduce tu nombre de usuario..." required></td>
                </tr>
                <tr>
                    <td><label for="contrasenya">Contraseña:</label></td>
                    <td colspan="3"><input type="password" name="contrasenya" id="contrasenya" style="width: 93%;" placeholder="Introduce tu contraseña..." required></td>
                </tr>
                <tr>
                    <td><input type="submit" name="enviar" value="INICIAR SESIÓN"></td>
                    <td colspan="2"><input type="reset" value="CANCELAR"></td>
                </tr>
            </table><br>
        </form>
    </fieldset>
</div>
<?php
require("includes/pie.php");
?>