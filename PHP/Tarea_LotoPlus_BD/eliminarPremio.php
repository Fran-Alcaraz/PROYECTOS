<?php
$titulo = "Eliminar Premio | LotoPlus";
require("includes/cabecera.php");

if(isset($_SESSION["usuarioAdmin"])){
    if (isset($_POST["eliminar"])) {
        $con = conectar();
        $idPremio = intval($_POST["eliminar"]);
        $sql = "DELETE FROM premios WHERE idpremio = $idPremio";
        $resultado = mysqli_query($con, $sql);

        if ($resultado) {
            // Redirige con un mensaje de éxito
            header("Location: premios.php?mensaje=Premio eliminado correctamente&tipoMensaje=success");
            exit;
        } else {
            // Redirige con un mensaje de error
            header("Location: premios.php?mensaje=Error al eliminar&tipoMensaje=error");
            exit;
        }
        mysqli_close($con);
    } else {
        echo "<p>No se recibió ningún premio para eliminar.</p>";
    }
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
require('includes/pie.php');
?>
