<?php
$titulo = "Menú principal | LotoPlus";
require("includes/cabecera.php");
if(isset($_GET["mensaje"]) && isset($_GET["tipoMensaje"]) && isset($_GET["titulo"]) && isset($_GET["colorIcono"])){
    $mensaje = htmlspecialchars($_GET["mensaje"], ENT_QUOTES, "UTF-8");
    $titulo = htmlspecialchars($_GET["titulo"], ENT_QUOTES, "UTF-8");
    $tipoMensaje = htmlspecialchars($_GET["tipoMensaje"], ENT_QUOTES, "UTF-8");
    $colorIcono = htmlspecialchars($_GET["colorIcono"], ENT_QUOTES, "UTF-8");
    echo "<script>
            Swal.fire({
                title: '$titulo',
                text: '$mensaje',
                icon: '$tipoMensaje',
                iconColor: '$colorIcono',
                confirmButtonText: 'Aceptar',
                customClass:{
                    confirmButton: 'btn-crear'
                }
            }).then(()=>{
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        </script>";
}

if (isset($_SESSION["usuarioValidado"]) || isset($_SESSION["usuarioAdmin"])){
    $nombreUsuario = isset($_SESSION["usuarioValidado"]) ? $_SESSION["usuarioValidado"] : $_SESSION["usuarioAdmin"];
    $con = conectar();
    $sql = "SELECT * from usuarios where nomusu = '$nombreUsuario';";
    $res = mysqli_query($con, $sql) or die(mysqli_error($con));
    $resultado = mysqli_fetch_array($res);

    $imagenValidada = "";
    if($resultado["validada"] === "N"){
        $imagenValidada = "images/noValidado.png";
        $texto = "Cuenta no validada";
    }else if($resultado["validada"] === "S"){
        $imagenValidada = "images/validado.png";
        $texto = "Cuenta validada";
    }
    ?>
    <div class="container-principal">
        <div class="container-usuario">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="text-align: left;">Perfil de <?php echo $nombreUsuario?></h3><img src="<?php echo $imagenValidada?>" alt="Icono de cuenta validada" width="50px" title="<?php echo $texto?>">
                <?php
                if(isset($_SESSION["usuarioValidado"])){
                    echo "<h3 style='margin-left: auto; margin-right: auto;'>Usuario normal</h3>";
                }else{
                    echo "<h3 style='margin-left: auto; margin-right: auto;'>Administrador</h3>";
                }
                ?>
            </div>
            <img src="<?php echo $resultado["imgusu"]?>" alt="Foto del usuario" width="150px">
            <table>
                <tr>
                    <td><b>Nombre: </b><?php echo $resultado["nombre"]?></td>
                    <td><b>Apellidos: </b><?php echo $resultado["apellidos"]?></td>
                </tr>
                <tr>
                    <td><b>Email: </b><?php echo $resultado["email"]?></td>
                    <td><b>Teléfono: </b><?php echo $resultado["tel"]?></td>
                </tr>
                <tr>
                    <td><b>Ganancias iniciales: </b><?php echo $resultado["ganancias"]?> €</td>
                    <td><b>Tipo cuenta: </b><?php echo $resultado["tipocu"]?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <form action='editarUsuario.php' method='post' id="editarUsuario">
                            <input type='hidden' name='editar' value="<?php echo $resultado["idusuario"]?>">
                            <input type='submit' value='Editar' id='editar'>
                        </form>
                    </td>
                </tr>
                <?php
                if($resultado["validada"] === "N"){?>
                <tr>
                    <td colspan="2"><a href="enviarCorreo.php" class="botones-usuario">Enviar correo de validación</a></td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan="2"><a href="desconectar.php" class="botones-usuario">Desconectar</a></td>
                </tr>
            </table>
        </div>
    </div>
<?php
}else {
    ?>
    <div class="container-principal">
        <div class="container-aviso">
            <h1>Debes iniciar sesión</h1>
            <p>Para ver tu información <a href="formularioIniciarSesion.php">inicia sesión</a></p>
            <p>Si no dispones de una cuenta de usuario <a href="formularioCrearUsuario.php">puedes crearla</a></p>
        </div>
    </div>

<?php
}
require("includes/pie.php");
?>